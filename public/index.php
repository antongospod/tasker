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
// Errors reporting
ini_set('display_errors', 1);
error_reporting(E_ALL);

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
$router->add('create', ['controller' => 'HomeController', 'action' => 'create']);
$router->add('edit/{id:\d+}', ['controller' => 'HomeController', 'action' => 'edit']);
$router->add('login', ['controller' => 'UserController', 'action' => 'login']);
$router->add('logout', ['controller' => 'UserController', 'action' => 'logout']);

try {
    $router->dispatch($_SERVER['QUERY_STRING']);
} catch (Exception $e) {
}
