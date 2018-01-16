<?php

// echo 'query string is .... ' . $_SERVER['QUERY_STRING'];


// require the controller class
//require_once '../App/Controllers/Posts.php';

/**
 * Composer
 */
require_once dirname(__DIR__) . '/vendor/autoload.php';
//Twig_Autoloader::register();

/**
 * Autoloader
 */
/*
spl_autoload_register(function($class) {
    $root = dirname(__DIR__); // get the parent directory
    $file = $root . '/' . str_replace('\\', '/', $class) . '.php';
    if (is_readable($file)) {
        require $file;
    }
});
*/

/**
 * Error and Exception Handling
 */
error_reporting(E_ALL);
set_error_handler('Core\Error::errorHandler');
set_exception_handler('Core\Error::ExceptionHandler');

/**
 * Routing
 */
//require_once '../Core/Router.php';
$router = new Core\Router();

// echo get_class($router);

// Add the routes
// /*
$router->add('', ['controller' => 'Home', 'action' => 'index']);
//$router->add('posts', ['controller' => 'Posts', 'action' => 'index']);
//$router->add('posts/new', ['controller' => 'Posts', 'action' => 'new']);
$router->add('{controller}/{action}');
$router->add('{controller}/{id:\d+}/{action}');
$router->add('admin/{controller}/{action}', ['namespace' => 'Admin']);


$url = $_SERVER['QUERY_STRING'];


//print_r($router);

/*
echo '<pre>';
echo htmlspecialchars(print_r($router->getRoutes(), true));
echo '</pre>';
if ($router->match($url)) {
    echo '<pre>';
    print_r($router->getParams());
    echo '</pre>';
} else {
    echo 'No route found for URL ' . $url;
}
*/

$router->dispatch($url);
