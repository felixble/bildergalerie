<?php
/**
 * Base View class containing the logic to
 * include the corresponding template.
 *
 * User: Felix
 * Date: 15.12.2015
 * Time: 19:18
 */

class View {

    /**
     * Default path where the templates are located.
     */
    const DEFAULT_TEMPLATE_PATH = "templates/";

    /**
     * The path to the template this view
     * is appendant.
     *
     * @var string
     */
    private $template;

    /**
     * Creates a new View with either a corresponding template
     * with the given template or the template by the naming
     * conventions.
     * <br>
     * Naming conventions:
     * <br>
     * <li>Name of the Class = {Identifier}View | first letter upper case</li>
     * <li>Template Name = {Identifier}.php     | first letter lower case</li>
     *
     * @param string|null $template
     */
    public function __construct($template = null) {
        if (is_null($template)) {
            $class_reflection = new \ReflectionClass(get_class($this));
            $class_name = $class_reflection->getShortName();
            $this->setTemplate($this->translateViewToTemplate($class_name));
        } else {
            $this->setTemplate($template, (strpos($template, "/") != true));
        }
    }

    /**
     * Sets the template.
     *
     * @param $template
     * @param bool $defaultPath
     */
    private function setTemplate($template, $defaultPath = true) {
        $this->template = ( ($defaultPath) ? self::DEFAULT_TEMPLATE_PATH . $template : $template ) . ".php";
    }

    /**
     * Converts the class name into the corresponding
     * template name.
     *
     * @param $viewClassName
     * @return string
     * @throws Exception
     */
    private function translateViewToTemplate($viewClassName) {
        $pos = strpos($viewClassName, "View");
        if ($pos === FALSE) {
            throw new \Exception("Illegal ViewClassName. Please make sure you adhere to the naming conventions.");
        }
        $template = strtolower($viewClassName);
        $template = substr($template, 0, $pos);

        if (empty($template)) {
            throw new Exception("Illegal ViewClassName. Please make sure you adhere to the naming conventions.");
        }

        return $template;
    }

    /**
     * Loads the template.
     *
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
     * Magic to string function displays the content
     * of the view.
     *
     * @return string
     */
    public function __toString() {
        try {
            return $this->loadTemplate();
        } catch (\Exception $e) {
            trigger_error("Exception thrown in __toString() method, which is is not supported. "
                . "EXCEPTION is converted into FATAL ERROR: EXCEPTION: ".$e->getMessage()." ## "
                . "For more information on this PHP core related issue, please refer to "
                . "http://stackoverflow.com/questions/2429642/why-its-impossible-to-throw-exception-from-tostring ",
                E_USER_ERROR);
            die("-- EXECUTION HALTED --");
        }
    }

    /**
     * Builds the url to relocate to a different
     * action.
     *
     * @param string|null $controller
     * @param string $action
     * @param array $params
     * @return string
     */
    public function url($controller = null, $action = "", $params = array())
    {
        return Router::getUrl($controller, $action, $params);
    }

    public function urlScrollTo($id)
    {
        return substr($_SERVER['REQUEST_URI'], strlen(MvcConfig::getInstance()->getBasePath())) . "#" . $id;
    }

    /**
     * Returns the custom css file of the view.
     *
     * @return string|array|null
     */
    public function getCustomCSS() { return null; }


} 