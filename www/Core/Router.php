<?php 

namespace Core;

/**
 * Front router
 * 
 * PHP V 7.4.30
 */

class Router {
    
    /**
     * Associative array of routes
     * @var array
     */
    protected $routes = [];

    /**
     * Parameters from the matched route
     * @var array
     */
    protected $params = [];

    /**
     * Get all the routes from the routing table
     * 
     * @return array
     */
    public function getRoutes() {
        return $this->routes;
    }

    /**
     * Get the currently matched params
     * 
     * @return array
     */
    public function getParams() {
        return $this->params;
    }

    /**
     * Add a route to the routing table
     * 
     * @param string $route    The route URL
     * @param array  $params   Parameters (controller, action, etc.)
     * 
     * @return void
     */
    public function add($route, $params = []) {
        // Convert the route to a regular expression: escape forward slashes
        $route = preg_replace("/\//", "\\/", $route);

        // Convert variables e.g. {controller}
        $route = preg_replace("/\{([a-z]+)\}/", '(?P<\1>[a-z-]+)', $route);

        // Convert variables with custom regular expressions eg. {id:\d+}
        $route = preg_replace("/\{([a-z]+):([^\}]+)\}/", '(?P<\1>\2)', $route);

        // Add start and end delimiters, and case insensitive flag
        $route = "/^" . $route . "$/i";

        $this->routes[$route] = $params;
    }

    /**
     * Match the route to the routes in the routing table, setting the $params
     * propoerty if a route is found
     * 
     * @param  string  $url    The route URL
     * @return boolean
     */
    public function match($url) {
        // Match to the fixed URL format /controller/action
        //$reg_exp = "/^(?P<controller>[a-z-]+)\/(?P<action>[a-z-]+)$/";
        foreach ($this->routes as $route => $params) {
            if (preg_match($route, $url, $matches)) {
                // $params = [];

                foreach ($matches as $key => $match) {
                    if (is_string($key)) {
                        $params[$key] = $match;
                    }
                }

                $this->params = $params;
                return true;
            }
        }

        return false;
    }

    /**
     * Dispatch the roue, creating the controller object and running the action 
     * method
     * 
     * @param string $url  The route URL
     * 
     * @return void
     */
    public function dispatch($url) {
        $url = $this->removeQueryStringVariables($url);

        if ($this->match($url)) {
            $controller = $this->params['controller'];
            $controller = $this->convertToUpperCamelCase($controller);
            $controller = $this->getNamespace() . $controller;

            if (class_exists($controller)) {
                $controller_object = new $controller($this->params);

                $action = $this->params['action'];
                $action = $this->convertToLowerCamelCase($action);

                if (preg_match('/action$/i', $action) == 0) {
                    $controller_object->$action();
                } else {
                    echo "Method $action (in controller $controller) not found";
                }
            } else {
                echo "Controller class $controller not found";
            }
        } else {
            echo "No route matched.";
        }
    }

    protected function removeQueryStringVariables($url) {
        if ($url != "") {
            $parts = explode("&", $url, 2);

            if (strpos($parts[0], "=") === false) {
                $url = $parts[0];
            } else {
                $url = "";
            }
        }

        return $url;
    }

    protected function getNamespace() {
        $namespace = "App\Controllers\\";

        if (array_key_exists("namespace", $this->params)) {
            $namespace .= $this->params["namespace"] . "\\";
        }

        return $namespace;
    }

    protected function convertToUpperCamelCase($string) {
        return str_replace(' ', '', ucwords(str_replace("-", " ", $string)));
    }

    protected function convertToLowerCamelCase($string) {
        return lcfirst($this->convertToUpperCamelCase($string));
    }
}