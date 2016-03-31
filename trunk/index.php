<?php
// The index.php is the single entry point into our application.
// Via the autoloader all necessary classes will be loaded and we set
// a exception handler to convert php errors into exceptions.
//
// Then we build a Request-Object by the incoming informations like
// Request_URI, GET- / POST-Parameters, Request-Method, Cookies and Files.
//
// With the information of the Request-Object we can start our AppRouter,
// which is responsible to determine the Controller class (see classes/controller),
// whose action - depending on the request - will be executed.
// Each action - which does not perform a relocate - returns a View-Object. Except
// the actions marked with the JsonResponse-Annotation. These are returning a json response.
// The Views return value can be printed via the "magic" __toString()-Method
// (see last line of this script).
//
// Which action of which controller is executed will be determined by the Request-URI.
// The default expression ist: /<controller>/<action>.
// If no action is given or the controller has no such action, the default action
// (index) of the given controller will be executed
// If neither a controller nor an action is given the default action of the
// HomeController will be executed.
// All further - by /-divided - strings will be interpreted as GET-Parameters.
//
// View-Basics:
// Each View-Class (see /classes/view/*) has a related template-file (see /templates).
// The base View-Class (see /includes/mvc_base/View.php) is responsible to load the
// template into the used View. Via the special "$this"-Variable we can access Methods
// from the View-Class inside the related template-file.
//
// Application-Architecture
// Inside the AppRouter (see /classes/application/AppRouter.php) we instantiate all important
// classes which should instantiate only be once like the database connection or the session
// management class. This will be done via a simple BaseFactory-Class (see /classes/core/BaseFactory).
// The instance of the baseFactory will be passed from the router directly to the currently used
// Controller-Class.
//
// External Files
// We use the composer to load third party libraries like twitter-bootstrap for the design,
// aura/session for better php session handling or simplon/mysql als simple mysql wrapper library
// to name same examples. All files downloaded by the composer are located under /vendor/.
// The composer is also responsible for building the classmap to load all files.
//
// Resources
// Static resources like css-/image- or javascript-files are located under /resources/. Some of the css/js-files
// are loaded for all views directly into the bootstrap html base frame (see /includes/mvc_base/templates/bootstrap.php)
// others are needed only for some views. These will be loaded in case they are defined in the getCustomJs()-/
// getCustomCss()-Method from the View.

// include the autoloader-script which is responsible to include all necessary class files
require __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/config.php'; // include the config-constants for our project

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
$request = new Request($_SERVER["REQUEST_URI"], $_GET, $_POST, $_SERVER["REQUEST_METHOD"], $_COOKIE, $_FILES);

// create a new Router-Object which is responsible to determine the correct controller and action-method
// from the given request.
$router = new AppRouter($request);

// print the return value from the executed action, which is the desired view.
echo $router->run();