<?php
require __DIR__ . '/vendor/autoload.php';

//=== Check cookies enabled ===//
/*session_start();
$a = session_id();
session_destroy();

session_start();
$b = session_id();
session_destroy();
$cookiesEnabled = $a==$b;
//=== Check cookies enabled ===//
*/


/*$dispatcher = new Dispatcher($_GET, $_POST);
$ctrl = $dispatcher->handle();
echo $ctrl->draw();
*/

$request = new Request($_SERVER["REQUEST_URI"], $_GET, $_POST, $_SERVER["REQUEST_METHOD"]);

$router = new Router($request);
echo $router->run();