<?php

/*
 * Router takes request and cuts it in Controller -> Action (Method)
 * example /user/login is cut to User -> login
 */
class Router {
    protected $controller = 'Pages';
    protected $method = 'index';
    protected $params = [];

    public function __construct() {

        $url = $this->getUrl();

        // check if first value is valid controller
        if (file_exists('../app/controllers/' . ucwords($url[0]) . '.php')) {
            // If exists, set as controller
            $this->controller = ucwords($url[0]);
            // unset first value
            unset($url[0]);
        }

        // Require controller
        require_once '../app/controllers/' . $this->controller . '.php';

        // Instantiate controller
        $this->controller = new $this->controller;

        // Check if url contains second value
        if (isset($url[1])) {
            // Check if method exists in controller
            if (method_exists($this->controller, $url[1])) {
                // if exists, set as method
                $this->method = $url[1];
                // Unset second value
                unset($url[1]);
            }
        }

        // Get params
        $this->params = $url ? array_values($url) : [];

        // call a method as a callback of params
        call_user_func_array([$this->controller, $this->method], $this->params);
    }

    public function getUrl() {
        // Prettify and explode url
        if (isset($_GET['url'])) {
            $url = rtrim($_GET['url'], '/');
            // remove all unnecessary characters
            $url = filter_var($url, FILTER_SANITIZE_URL);
            // explode into array
            $url = explode('/', $url);
            return $url;
        }
    }
}
