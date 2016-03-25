<?php
/**
 * Router class to determine the controller
 * from the url and executes the chosen
 * action.
 * <br>
 * URL-Format: /controller/action/parameters
 * <br>
 * Default Values:
 * <li>no controller given -> default controller defined in MvcConfig</li>
 * <li>no action given -> default action defined in MvcConfig</li>
 * <br>
 *
 * User: Felix
 * Date: 15.12.2015
 * Time: 19:15
 */

class Router {
    const MAX_REROUTE_COUNT = 10;

    /**
     * The current request object.
     *
     * @var Request
     */
    private $request;

    /**
     * The chosen controller which is
     * responsible for the executed action.
     *
     * @var Controller
     */
    private $controller;

    /**
     * The chosen action which will
     * be shown.
     *
     * @var string
     */
    private $action;

    /**
     * @var array
     */
    private $reRouteStack;

    /**
     * Builds the url to relocate to a different
     * action.
     *
     * @param string|null $controller
     * @param string $action
     * @param array $params
     * @param string $scrollTo id
     * @return string
     */
    public static function getUrl($controller = null, $action = "", $params = array(), $scrollTo = "")
    {
        if (null == $controller ) {
            $controller = MvcConfig::getInstance()->getDefaultControllerName();
        }
        if (!empty($action)) {
            $action = "/" . $action;
        }

        $url = $controller . $action;

        foreach($params as $key => $val) {
            $url .= "/" . $key . "/" . $val;
        }

        if (!empty($scrollTo)) {
            $url .= "#" . $scrollTo;
        }

        return $url;
    }


    /**
     * Creates a new Router which makes the
     * routing decisions by the given
     * {@link Request}-Object.
     *
     * @param Request $request
     */
    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    /**
     * Cleans the input from invalid tokens.
     *
     * @param $input string
     * @return string
     */
    private static function sanitizeRouterInput($input)
    {
        return ucfirst(preg_replace("/[^a-zA-Z]+/", "", $input));
    }

    /**
     * Converts a given input-string into
     * a correct name of a class.
     *
     * @param $class string
     * @return string
     */
    private static function inputToClassName($class)
    {
        return ucfirst(self::sanitizeRouterInput($class))."Controller";
    }

    /**
     * Appends the correct method appendix for a
     * action-method.
     *
     * @param $method string
     * @return string complete name of the action method
     */
    private static function appendActionMethodAppendix($method)
    {
        return self::sanitizeRouterInput($method)."Action";
    }

    /**
     * Performs the routing algorithm and returns
     * the {@link View} returned from the executed action.
     *
     * @return View {@link View} returned from the executed action.
     * @throws Exception
     */
    private function route()
    {
        $ctrlUnknown = false;
        $reqUri = $this->request->getRequestUri();
        if (substr($reqUri, 0, 9) == "index.php") {
            $reqUri = (substr($reqUri, 9, 1) == "/") ? substr($reqUri, 10) : substr($reqUri, 9);
        }
        if (substr($reqUri, -1) == "/") {
            $reqUri = substr($reqUri, 0, -1);
        }
        $queryArr = explode("/", $reqUri);

        // if there are normal get params the last item has the question tag
        if (count($queryArr) > 0 && strpos($queryArr[count($queryArr)-1], "?")) {
            $pos = strpos($queryArr[count($queryArr)-1], "?");
            $queryArr[count($queryArr)-1] = substr($queryArr[count($queryArr)-1], 0, $pos);
        }

        $controller = MvcConfig::getInstance()->getDefaultControllerName();
        $possibleAction = null;
        $action = self::appendActionMethodAppendix(MvcConfig::getInstance()->getDefaultActionName());
        if (!empty($reqUri) && count($queryArr) == 1) { // nur ein Parameter -> controller
            $controller = $queryArr[0];
        } elseif (count($queryArr) > 1) {
            $controller = $queryArr[0];
            $possibleAction = $queryArr[1];
        }

        $controller = self::inputToClassName($controller);

        // does the controller class exist?
        if (!class_exists($controller)) {
            $controller = self::inputToClassName("Unknown");
            $ctrlUnknown = true;
        }

        $controllerName = $controller;
        $controller = new $controller();

        if (!$controller instanceof Controller) {
            throw new Exception("Invalid Controller");
        }


        $possibleAction = self::appendActionMethodAppendix($possibleAction);

        if (!$ctrlUnknown && $possibleAction != null) {
            // what is action, what is get parameter ?
            if (method_exists($controller, $possibleAction)) {
                // the method exists, so we found our action to execute
                $action = $possibleAction;
                $this->convertQueryArrayToGetArray($queryArr, 2);
            } else {
                // the method does not exist, so we select the index action and pass the parameters
                $this->convertQueryArrayToGetArray($queryArr, 1);
            }
        }

        $this->onRequestBuilt($this->request);
        $this->setControllerAndAction($controllerName, $action, $controller);
    }

    private function setControllerAndAction($controllerName, $actionName, $controller = null)
    {
        $this->reRouteStack[] = array("Controller" => $controllerName, "Action" => $actionName);

        if (null == $controller) { // controller is not instantiated right now
            $controller = new $controllerName();

            if (!$controller instanceof Controller) {
                throw new Exception("Invalid Controller");
            }
        }
        $this->controller = $controller;

        $this->controller->onCreate($this);
        $this->action = $actionName;

        if (!method_exists($this->controller, $this->action)) {
            throw new \Exception("Invalid Action!");
        }
    }

    private function performReRouting(ReRouteRequestException $e)
    {
        $this->setControllerAndAction($e->getController(), $e->getAction());
    }

    /**
     * Runs the controller and displays the view of
     * the action.
     *
     * @return View
     * @throws Exception
     */
    private function runController()
    {
        $this->preRunController($this->controller, $this->action);

        $actionName = $this->action;
        $view = $this->controller->$actionName();

        if (!$this->isJsonResponse() && !($view instanceof View)) {
            throw new Exception("Invalid View - did you forgot to return the view?");
        }

        return $view;
    }

    /**
     * Converts the given {@link Exception} into
     * a {@link ExceptionView} which can be displayed
     * for the user.
     *
     * @param Exception $e Exception to convert into a {@link ExceptionView}
     * @param bool $jsonResponse
     * @return BootstrapView
     */
    protected function exceptionHandler(\Exception $e, $jsonResponse = false)
    {
        if ($jsonResponse) {
            $jsonArr = array(
                "status"    => "ERR",
                "err"       => get_class($e),
                "errCode"   => $e->getCode(),
                "errMsg"    => $e->getMessage(),
                "errFile"   => $e->getFile(),
                "errLine"   => $e->getLine()
            );

            return json_encode($jsonArr);
        }

        $exceptionView = new ExceptionView();
        $exceptionView->setInfosFromException($e);
        // TODO: Show bildergalerie page wrapper (content_frame) !
        return BootstrapHelper::getContentFrameView("Error occured!", $exceptionView);
    }

    /**
     * Performs the routing algorithm and displays
     * the applications content.
     *
     * @return View
     */
    public function run()
    {
        try {
            $this->route();

            while (!$this->maxReRouteCount()) {
                try {
                    return $this->runController();
                } catch (ReRouteRequestException $e) {
                    $this->performReRouting($e);
                }
            }

            throw new ReRoutingException($this->reRouteStack);
        } catch (\Exception $e) {
            if ($this->isJsonResponse()) {
                return $this->exceptionHandler($e, true);
            }
            header("HTTP/1.1 500 Internal Server Error");
            return $this->exceptionHandler($e, false);
        }

    }

    public function reLocateTo($controller = null, $action = "", $params = array())
    {
        // mod_rewrite workaround ...
        $requestUri = $_SERVER['REQUEST_URI'];
        $virtualPath = substr($requestUri, strlen(MvcConfig::getInstance()->getBasePath()));
        $count = count(explode("/", $virtualPath));
        $prefix = "";
        if ($count > 1) { // 2 -> ../ as prefix
            while ($count > 1) {
                $prefix .= "../";
                $count--;
            }
        }

        $url = $prefix . self::getUrl($controller, $action, $params);
        header('Location: ' . $url, true, 303);
        exit;
    }

    public function reRouteTo($controller, $action)
    {
        throw new ReRouteRequestException(
            self::inputToClassName($controller),
            self::appendActionMethodAppendix($action)
        );
    }

    public function rewindAndRestartRouting()
    {
        $start_controller = $this->reRouteStack[0]["Controller"];
        $start_action = $this->reRouteStack[0]["Action"];
        throw new ReRouteRequestException($start_controller, $start_action);
    }

    /**
     * Reads the query array containing key followed
     * by its value as a list (key1,val1,key2,val2,...)
     * and inserts the pairs into our {@link Request}-Object.
     *
     * @param $queryArr
     * @param $startIndex
     */
    private function convertQueryArrayToGetArray($queryArr, $startIndex)
    {
        $index = $startIndex;
        while ($index < count($queryArr)) {
            $val = ($index+1 == count($queryArr)) ? "" : $queryArr[$index+1];
            $this->request->addGetParam($queryArr[$index], $val);
            $index += 2;
        }
        $this->request->setQueryParamsArray(array_slice($queryArr, $startIndex));
    }

    private function maxReRouteCount()
    {
        return (count($this->reRouteStack) > self::MAX_REROUTE_COUNT);
    }

    public function getRequest()
    {
        return $this->request;
    }

    /**
     * This method will be invoked the moment before
     * the action of the controller will be executed.
     *
     * @param $controller Controller Controller which will be run
     * @param $action string action which will be executed
     */
    protected function preRunController(Controller $controller, $action)
    {
    }

    /**
     * Method will be called the moment the request
     * is completely built.
     *
     * @param $request Request
     */
    protected function onRequestBuilt(Request $request)
    {
    }

    private function isJsonResponse()
    {
        if (null != $this->controller && $this->controller instanceof Controller) {
            $annotations = $this->controller->getAnnotationParser()->getAnnotations();
            return $annotations->has("JsonResponse");
        }
        return false;
    }

} 