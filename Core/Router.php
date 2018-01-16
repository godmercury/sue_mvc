<?php

namespace Core;

/**
 * Router
 */
class Router
{
    /**
     * Associative array of routes (the routing table)
     * @var array
     */
    protected $routes = [];

    /**
     * Parameters from the matched routes
     * @var array
     */
    protected $params = [];

    /**
     * Add a route to the routing table
     *
     * @param string $route The route CURLFile
     * @param array $params Parameters (controller, action, ect.)
     *
     * @return void
     */
    public function add($route, $params = [])
    {
        // Convert the route to a regular expression : escape forward slashes
        $route = preg_replace('/\//', '\\/', $route);

        // Convert variables e.g. {controller}
        $route = preg_replace('/\{([a-z]+)\}/', '(?P<\1>[a-z-]+)', $route);

        // Convert variables with custom regular expressions e.g. {id:\d+}
        $route = preg_replace('/{([a-z]+):([^\}]+)\}/', '(?P<\1>\2)', $route);

        // Add start and end delimiters, and case insensitive flag
        $route = '/^' . $route . '$/i';

        $this->routes[$route] = $params;
    }

    /**
     * Get all the routes from the routing table
     *
     *  @return array
     */
    public function getRoutes()
    {
        return $this->routes;
    }

    /**
     * Match the route to the routes in the routing table, setting the $params property if a route is found.
     *
     * @param string $url The route URL
     *
     * @return boolean true if a match found, false otherwise
     */
    public function match($url)
    {
        /*
        foreach ($this->routes as $route => $params) {
            if ($url === $route) {
                $this->params = $params;
                return true;
            }
        }

        return false;
        */

        /*
        // Match to the fixed URL format /controller/action
        $reg_exp = '/^(?P<controller>[a-z-]+)\/(?P<action>[a-z-]+)$/';

        if (preg_match($reg_exp, $url, $matches)) {
            // Get named capture group values
            $params = [];

            foreach ($matches as $key => $match) {
                if (is_string($key)) {
                    $params[$key] = $match;
                }
            }

            $this->params = $params;
            return true;
        }

        return false;
        */

        foreach ($this->routes as $route => $params) {
            if (preg_match($route, $url, $matches)) {
                // Get named capture group values

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
     * Get the currently matched Parameters
     *
     * @return array
     */
    public function getParams()
    {
        return $this->params;
    }

    /**
     * Dispatch the route, creating the controler object and running the action method
     *
     * @param string $url The route URL
     *
     * @return void
     */
    public function dispatch($url)
    {
        $url = $this->removeQueryStringVariables($url);

        if ($this->match($url)) {
            $controller = $this->params['controller'];
            $controller = $this->convertToStudlyCaps($controller);
            //$controller = 'App\Controllers\\' . $controller;
            $controller = $this->getNamespace() . $controller;

            if (class_exists($controller)) {
                $controller_object = new $controller($this->params);

                $action = $this->params['action'];
                $action = $this->convertToCamelCase($action);

                /*
                if (is_callable([$controller_object, $action])) {
                    $controller_object->$action();
                } else {
                    echo '<p>Method ' . $action . ' (in controller ' . $controller . ') not found.</p>';
                }
                */
               if (preg_match('/action$/i', $action) === 0) {
                   $controller_object->$action();
               } else {
                   throw new \Exception('Method ' . $action . ' in controller ' . $controller . ' cannot be called directly - remove the Action suffix to call this method.');
               }
            } else {
                // echo '<p>Controller class ' . $controller . ' not found.</p>';
                throw new \Exception('Controller class ' . $controller . ' not found.');
            }
        } else {
            throw new \Exception('No route matched.', 404);
            // echo '<p>No route matched.</p>';
        }
    }

    /**
     * Convert the string with hyphens to StudlyCaps, e.g. post-authors => PostAuthors
     *
     * @param string $string The string to convert
     *
     * @return string
     */
    private function convertToStudlyCaps($string)
    {
        return str_replace(' ', '', ucwords(str_replace('-', ' ', $string)));
    }

    /**
     * Convert the string with hyphens to camelCase, e.g. add-new => addNew
     *
     * @param string $string The string to convert
     *
     * @return string
     */
    private function convertToCamelCase($string)
    {
        return lcfirst($this->convertToStudlyCaps($string));
    }

    /**
     * Remove the query string variables from the URL (if any).
     * As the full query string is used for the route, any variables at the end will
     * need to be a removed before the route is matched to the routing table.
     * A URL of the format localhost/?page(one variable name, no value) won't work however.
     *
     * @param string $url The full URL
     *
     * @return string The URL the query string variables removed
     */
    private function removeQueryStringVariables($url)
    {
        if ($url !== '') {
            $parts = explode('&', $url, 2);

            if (strpos($parts[0], '=') === false) {
                $url = $parts[0];
            } else {
                $url = '';
            }
        }

        return $url;
    }

    /**
     * Get the namespace for the controller class.
     * The namespace defined in the route parameters is added if present.
     *
     * @return string The requeest URL
     */
    private function getNamespace()
    {
        $namespace = 'App\Controllers\\';

        if (array_key_exists('namespace', $this->params)) {
            $namespace .= $this->params['namespace'] . '\\';
        }

        return $namespace;
    }













}
