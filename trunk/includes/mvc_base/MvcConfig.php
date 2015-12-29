<?php
/**
 * Singleton-Class containing all configuration
 * details for this simple mvc pattern, like
 * names for the default controller/action.
 *
 * User: Felix
 * Date: 16.12.2015
 * Time: 00:51
 */

class MvcConfig {

    const _DEFAULT_CONTROLLER = "home";
    const _DEFAULT_ACTION = "index";
    private static  $_INSTANCE = null;

    public static function getInstance() {
        if (null === self::$_INSTANCE) {
            self::$_INSTANCE = new MvcConfig();
        }

        return self::$_INSTANCE;
    }

    /**
     * Applications project path relative to
     * the webservers' root directory.
     *
     * @var string|null
     */
    private $basePath = null;

    private $defaultControllerName = self::_DEFAULT_CONTROLLER;
    private $defaultActionName = self::_DEFAULT_ACTION;

    private function __construct() {

    }

    /**
     * Gets the applications project path relative
     * to the webservers' root directory.
     * <br>
     * If the base path is not set it will be
     * calculated by the path of the currently
     * executed script (this is usually the index.php
     * script located in the projects main directory).
     *
     * @return string
     */
    public function getBasePath()
    {
        if (null == $this->basePath) {
            $this->basePath = self::scriptNameToBasePath();
        }
        return $this->basePath;
    }

    /**
     * Sets the applications project path relative
     * to the webservers' root directory.
     *
     * @param string $basePath
     */
    public function setBasePath($basePath)
    {
        $this->basePath = $basePath;
    }

    /**
     * Gets the name of the default action.
     *
     * @return string
     */
    public function getDefaultActionName()
    {
        return $this->defaultActionName;
    }

    /**
     * Sets the name of the default action.
     *
     * @param string $defaultActionName
     */
    public function setDefaultActionName($defaultActionName)
    {
        $this->defaultActionName = $defaultActionName;
    }

    /**
     * Gets the name of the default controller.
     *
     * @return string
     */
    public function getDefaultControllerName()
    {
        return $this->defaultControllerName;
    }

    /**
     * Sets the name of the default controller.
     *
     * @param string $defaultControllerName
     */
    public function setDefaultControllerName($defaultControllerName)
    {
        $this->defaultControllerName = $defaultControllerName;
    }


    /**
     * Calculates the application path from the
     * path of the script currently executed.
     *
     * @return string
     */
    private static function scriptNameToBasePath() {
        $scriptName = $_SERVER["SCRIPT_NAME"];
        $pos = strripos($scriptName, "/");
        if ($pos !== false) {
            return substr($scriptName, 0, $pos+1);
        } else {
            return "/";
        }
    }


} 