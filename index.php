<?php

require_once './config/config.php';
Loader::include('Router');

$routes = new Router;

$routes->bind('', function($action, $params) {
    view('welcome', [
        'welcomename' => 'WORKING!!!'
    ]);
});

$routes->dispatch();