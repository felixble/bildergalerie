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
     * @var array
     */
    private $getParam;
    private $postParam;
    private $requestMethod;

    public function __construct($requestUri, $get, $post, $requestMethod) {
        $this->requestUri = substr($requestUri, strlen(MvcConfig::getInstance()->getBasePath()));
        $this->getParam = $get;
        $this->postParam = $post;
        $this->requestMethod = $requestMethod;
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