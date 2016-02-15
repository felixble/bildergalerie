<?php
// include the autoloader-script which is responsible to include all necessary class files
require __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/config.php';

/**
 * Function to convert all php errors
 * (except fatal errors) into an exception
 * so they will be displayed in our exception view.
 *
 * @param $errno
 * @param $errstr
 * @param $errfile
 * @param $errline
 * @throws ErrorHandler
 */
function exception_error_handler($errno, $errstr, $errfile, $errline ) {
    throw new ErrorHandler($errstr, 0, $errno, $errfile, $errline);
}

// set our error to exception converter as global exception handler
set_error_handler("exception_error_handler", E_ALL);

// build the request object containing the request uri, all get and post parameters together
// with the cookies array
$request = new Request($_SERVER["REQUEST_URI"], $_GET, $_POST, $_SERVER["REQUEST_METHOD"], $_COOKIE);

// create a new Router-Object which is responsible to determine the correct controller and action-method
// from the given request.
$router = new AppRouter($request);

// print the return value from the executed action, which is the desired view.
echo $router->run();