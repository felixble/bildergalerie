<?php
/**
 * Created by PhpStorm.
 * User: Felix
 * Date: 15.12.2015
 * Time: 19:18
 */

class View {

    const DEFAULT_TEMPLATE_PATH = "templates/";

    private $template;

    public function __construct($template = null) {
        if (is_null($template)) {
            $class_reflection = new \ReflectionClass(get_class($this));
            $class_name = $class_reflection->getShortName();
            $this->setTemplate($this->translateViewToTemplate($class_name));
        } else {
            $this->setTemplate($template, (strpos($template, "/") != true));
        }
    }

    private function setTemplate($template, $defaultPath = true) {
        $this->template = ( ($defaultPath) ? self::DEFAULT_TEMPLATE_PATH . $template : $template ) . ".php";
    }


    private function translateViewToTemplate($viewClassName) {
        $pos = strpos($viewClassName, "View");
        if ($pos === FALSE) throw new \Exception("Illegal ViewClassName. Please make sure you adhere to the naming conventions.");
        $template = strtolower($viewClassName);
        $template = substr($template, 0, $pos);

        if (empty($template)) throw new Exception("Illegal ViewClassName. Please make sure you adhere to the naming conventions.");

        return $template;
    }

    /**
     * @return string
     * @throws Exception
     */
    protected function loadTemplate() {
        $file = $this->template;
        $exists = file_exists($file);

        if ($exists) {
            // Output des Scripts wird in einen Buffer gespeichert.
            ob_start();

            // Template wird eingebunden
            include $file;
            $output = ob_get_contents();
            ob_end_clean();

            return $output;
        } else {
            throw new \Exception ("Laden des Templates $file fehlgeschlagen.");
        }
    }

    /**
     * @return string
     */
    public function __toString() {
        try {
            return $this->loadTemplate();
        } catch (\Exception $e) {
            trigger_error("Exception thrown in __toString() method, which is is not supported. EXCEPTION is converted into FATAL ERROR: EXCEPTION: ".$e->getMessage()." ## For more information on this PHP core related issue, please refer to http://stackoverflow.com/questions/2429642/why-its-impossible-to-throw-exception-from-tostring ", E_USER_ERROR);
            die("-- EXECUTION HALTED --");
        }
    }


    public function url($controller = null, $action = "", $params = array())
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

        return $url;
    }

} 