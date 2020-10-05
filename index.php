<?php

require_once './config/config.php';
Loader::include('Router');

$routes = new Router;

$routes->bind('', function($action, $params) {
    echo "
        <p align='center' style='width: 40vw; margin: 55px auto;'>
            <img width='100%' src='https://engineering.giphy.com/wp-content/uploads/2018/02/ai.gif'>
        </p>
        <p align='center' style='font-family: monospace; font-size: 16px; letter-spacing:6px'> 
            Happy gardening!
        </p>
    ";

});

$routes->dispatch();