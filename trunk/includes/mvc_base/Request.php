<?php
/**
 * Request-Class containing all information
 * concerning the client request.
 *
 * User: Felix
 * Date: 15.12.2015
 * Time: 19:15
 */

class Request {

    /**
     * The request url containing
     * the controller, the action
     * and other parameters.
     *
     * @var string
     */
    private $requestUri;

    /**
     * All get parameters.
     *
     * @var array
     */
    private $getParam;

    /**
     * All post parameters.
     *
     * @var array
     */
    private $postParam;

    /**
     * Request method (get/post)
     *
     * @var string
     */
    private $requestMethod;

    /**
     * Cookies.
     *
     * @var array
     */
    private $cookies;

    /**
     * Files.
     *
     * @var array
     */
    private $files;

    /**
     * Creates a new request object.
     *
     * @param $requestUri
     * @param $get
     * @param $post
     * @param $requestMethod
     * @param array $cookies
     * @param array $files
     */
    public function __construct($requestUri, $get, $post, $requestMethod, $cookies = [], $files = [])
    {
        $this->requestUri = substr($requestUri, strlen(MvcConfig::getInstance()->getBasePath()));
        $this->getParam = $get;
        $this->postParam = $post;
        $this->requestMethod = $requestMethod;
        $this->cookies = $cookies;
        $this->files = $files;
    }

    /**
     * @return mixed
     */
    public function getGetParam()
    {
        return $this->getParam;
    }

    /**
     * @return mixed
     */
    public function getPostParam()
    {
        return $this->postParam;
    }

    /**
     * @return mixed
     */
    public function getRequestMethod()
    {
        return $this->requestMethod;
    }

    /**
     * @return array
     */
    public function getCookies()
    {
        return $this->cookies;
    }

    /**
     * @return array
     */
    public function getFiles()
    {
        return $this->files;
    }

    /**
     * @return string
     */
    public function getRequestUri()
    {
        return $this->requestUri;
    }

    public function addGetParam($key, $val)
    {
        $this->getParam[$key] = $val;
    }


}