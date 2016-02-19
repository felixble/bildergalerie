<?php

/**
 * Created by PhpStorm.
 * User: Felix
 * Date: 14.02.2016
 * Time: 17:55
 */
use Notoj\ReflectionClass;

class ControllerAnnotationParser
{
    /**
     * @var Controller
     */
    private $controller;

    /**
     * @var ReflectionClass
     */
    private $reflectionClass;

    public function __construct(Controller $controller) {
        $this->controller = $controller;
        $this->reflectionClass = new ReflectionClass($this->controller);
    }

    /**
     * @param $method
     * @return \Notoj\Annotation\Annotations
     * @throws \BadMethodCallException
     */
    public function getAnnotationsForMethod($method) {
        if (!$this->reflectionClass->hasMethod($method)) throw new \BadMethodCallException("Method not found!");
        return $this->reflectionClass->getMethod($method)->getAnnotations();
    }

    /**
     * @return array|\Notoj\Annotation\Annotations
     */
    public function getAnnotations() {
        return $this->reflectionClass->getAnnotations();
    }
}