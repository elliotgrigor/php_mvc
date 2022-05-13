<?php

class Request
{
    public $method;
    public $route;
    public $queryString;
    
    public $args;

    public function __construct() {
        $this->method      = $_SERVER['REQUEST_METHOD'];
        $this->route       = explode('?', $_SERVER['REQUEST_URI'])[0];
        $this->queryString = $_SERVER['QUERY_STRING'];
    }
}