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
        $queryArr = explode("/", $reqUri);
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

        // existiert der Controller?
        if (!class_exists($controller)) {
            $controller = self::inputToClassName("Unknown");
            $ctrlUnknown = true;
        }

        $this->controller = new $controller($this->request);

        if (!$this->controller instanceof Controller) {
            throw new Exception("Invalid Controller");
        }


        $possibleAction = self::appendActionMethodAppendix($possibleAction);

        if (!$ctrlUnknown && $possibleAction != null) {
            // ermittle action & getParam-parameter
            if (method_exists($this->controller, $possibleAction)) {
                // es gibt die methode, also ist es unsere Action
                $action = $possibleAction;
                $this->convertQueryArrayToGetArray($queryArr, 2);
            } else {
                // es handelt sich wohl um die index-Action
                $this->convertQueryArrayToGetArray($queryArr, 1);
            }
        }

        $view = $this->controller->$action();

        if (!($view instanceof View)) {
            throw new Exception("Invalid View");
        }

        return $view;
    }

    /**
     * Converts the given {@link Exception} into
     * a {@link ExceptionView} which can be displayed
     * for the user.
     *
     * @param Exception $e Exception to convert into a {@link ExceptionView}
     * @return BootstrapView
     */
    private function exceptionHandler(\Exception $e)
    {
        $exceptionView = new ExceptionView();
        $exceptionView->setInfosFromException($e);
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
            return $this->route();
        } catch (\Exception $e) {
            header("HTTP/1.1 500 Internal Server Error");
            return $this->exceptionHandler($e);
        }

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
    }

} 