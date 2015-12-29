<?php
require __DIR__ . '/vendor/autoload.php';

function exception_error_handler($errno, $errstr, $errfile, $errline ) {
    throw new ErrorHandler($errstr, 0, $errno, $errfile, $errline);
}
set_error_handler("exception_error_handler", E_ALL);


$request = new Request($_SERVER["REQUEST_URI"], $_GET, $_POST, $_SERVER["REQUEST_METHOD"], $_COOKIE);
$router = new Router($request);

echo $router->run();