<?php
require __DIR__ . '/vendor/autoload.php';

$request = new Request($_SERVER["REQUEST_URI"], $_GET, $_POST, $_SERVER["REQUEST_METHOD"]);

$router = new Router($request);
echo $router->run();