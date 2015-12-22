<?php
/**
 * Created by PhpStorm.
 * User: Felix
 * Date: 15.12.2015
 * Time: 19:15
 */

class Router {

    private $request;
    private $controller;

    public function __construct(Request $request) {
        $this->request = $request;
    }

    private static function sanitizeRouterInput($input) {
        return ucfirst(preg_replace("/[^a-zA-Z]+/", "", $input));
    }

    private static function prependNamespaceAndAppendAppendix($class) {
        return ucfirst(self::sanitizeRouterInput($class))."Controller";
    }

    private static function appendActionMethodAppendix($method) {
        return self::sanitizeRouterInput($method)."Action";
    }

    private function route() {
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

        $controller = self::prependNamespaceAndAppendAppendix($controller);

        // existiert der Controller?
        if (!class_exists($controller)) {
            $controller = self::prependNamespaceAndAppendAppendix("Unknown");
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

    private function exceptionHandler(\Exception $e) {
        $exceptionView = new ExceptionView();

        $exceptionView->setExceptionName(get_class($e));
        $exceptionView->setExceptionText("<code>".$e->getMessage()."</code><br>Code: ".$e->getCode()."<br> File: ".$e->getFile()."<br>Line: ".$e->getLine()."<pre>".$e->getTraceAsString()."</pre>");


        return BootstrapHelper::getContentFrameView("Error occured!", $exceptionView);
    }

    public function run() {
        try {
            return $this->route();
        } catch (\Exception $e) {
            header("HTTP/1.1 500 Internal Server Error");
            return $this->exceptionHandler($e);
        }

    }

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