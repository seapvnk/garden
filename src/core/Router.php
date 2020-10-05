<?php

class Router
{
    private $routes = [];

    public function bind(string $path, $controller)
    {
        if (is_string($controller)) {
            Loader::include($controller, 'Controller');
        }
        
        $this->routes[$path] = $controller;
    }

    public function bindMany(array $routes)
    {
        foreach ($route as $path => $controller) {
            $this->routes[$path] = $controller;
        }
    }

    public function dispatch()
    {

        try {
            $url = $_SERVER['REQUEST_URI'];

            $parts = explode('/', $url);
            $parts = array_slice($parts, 2);
            
            $route = $parts[0];
            $action = $parts[1]?? null;
            $params = array_slice($parts, 2)?? null;

            if (!isset($this->routes[$route])) throw new Exception('404'); 
            
            $controller = $this->routes[$route];
            $result = $controller($action, $params);
            
            return $result;
        } catch (Exception $e) {
            return (new View(["message" => "this page doesn't exists"]))->output(400);
        }
        
    }

}