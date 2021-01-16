<?php
/**
 * Front controller
 */

/**
 * Autoload with Composer
 */
require dirname(__DIR__) . '/vendor/autoload.php';


/**
 * Error and Exception handling
 */
error_reporting(E_ALL);
set_error_handler('Core\Error::errorHandler');
set_exception_handler('Core\Error::exceptionHandler');

/**
 * Start Session
 */
session_start();

/**
 * Routing
 */
$router = new Core\Router();

// Add the routes
$router->add('', ['controller' => 'HomeController', 'action' => 'index']);
$router->add('{controller}/{action}');

try {
    $router->dispatch($_SERVER['QUERY_STRING']);
} catch (Exception $e) {
}
