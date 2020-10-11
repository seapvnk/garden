<?php

class Router
{
    private $routes = [];

    public function bind(string $path, $controller = null)
    {
        if (!$controller) {
            $controller = $path;
        }
        if (is_string($controller)) {
            Loader::include($controller, 'Controller');
        }
        
        $this->routes[$path] = $controller;
    }

    public function unbind(string $path)
    {
        unset($this->routes[$path]);
    }

    public function protect($condition, array $routes, $accessDenied)
    {
        if ($condition) {
            foreach ($routes as $route) {

                if (is_string($accessDenied)) {
                    Loader::include($accessDenied, 'Controller');
                }

                $this->bind($route, $accessDenied);
            }
        }
    }

    public function bindall(array $routes)
    {
        foreach ($routes as $route) {
            Loader::include($route, 'Controller');
            $this->routes[$route] = $route;
        }
    }

    public function dispatch($json = false)
    {

        try {
            $url = $_SERVER['REQUEST_URI'];

            $parts = explode('/', $url);
            $parts = array_slice($parts, 2);
            
            $route = $parts[0];
            $action = $parts[1]?? null;
            $params = array_slice($parts, 2)?? null;

            if (!isset($this->routes[$route])) {
                if ($json)
                    return (new View(["message" => "this page doesn't exists"]))->outputJSON(400);
                else
                    return view('404');
            }

            $controller = $this->routes[$route];
            $result = $controller($action, $params);
            
            return $result;
        } catch (Exception $e) {
            return (new View(["message" => "this page doesn't exists"]))->outputJSON(400);
        }
        
    }

}
