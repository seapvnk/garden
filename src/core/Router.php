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
        $url = $_SERVER['REQUEST_URI'];

        $parts = explode('/', $url);
        $parts = array_slice($parts, 2);

        $route = $parts[0];
        $action = $parts[1]?? null;
        $params = array_slice($parts, 2)?? null;
        
        
        if (!array_key_exists($route, $this->routes)) {
            return (new View())->output(400);
        }

        $controller = $this->routes[$route];
        return $controller($action, $params);
    }

}