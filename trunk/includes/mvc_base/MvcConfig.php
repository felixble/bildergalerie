<?php
/**
 * Created by PhpStorm.
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

    private $basePath = null;

    private $defaultControllerName = self::_DEFAULT_CONTROLLER;
    private $defaultActionName = self::_DEFAULT_ACTION;

    private function __construct() {

    }

    /**
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
     * @param string $basePath
     */
    public function setBasePath($basePath)
    {
        $this->basePath = $basePath;
    }

    /**
     * @return string
     */
    public function getDefaultActionName()
    {
        return $this->defaultActionName;
    }

    /**
     * @param string $defaultActionName
     */
    public function setDefaultActionName($defaultActionName)
    {
        $this->defaultActionName = $defaultActionName;
    }

    /**
     * @return string
     */
    public function getDefaultControllerName()
    {
        return $this->defaultControllerName;
    }

    /**
     * @param string $defaultControllerName
     */
    public function setDefaultControllerName($defaultControllerName)
    {
        $this->defaultControllerName = $defaultControllerName;
    }



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