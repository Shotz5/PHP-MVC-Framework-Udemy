<?php

/**
 * Front controller
 * 
 * PHP Version 7.4.30
 */

// // Require the controller class
// require "../App/Controllers/Posts.php";

/**
 * Twig
 */
require_once dirname(__DIR__) . '/vendor/autoload.php';

/**
 * Autoloader
 */
spl_autoload_register(function ($class) {
    $root = dirname(__DIR__);
    $file = $root . "/" . str_replace("\\", "/", $class) . ".php";
    if (is_readable($file)) {
        require $root . "/" . str_replace("\\", "/", $class) . ".php";
    }
});

// /**
//  * Router
//  */
// require "../Core/Router.php";
// $router = new Router();

$router = new Core\Router();

$router->add("", ["controller" => "Home", "action" => "index"]);
$router->add('{controller}/{action}');
$router->add('{controller}/{id:\d+}/{action}');
$router->add("admin/{controller}/{action}", ["namespace" => "Admin"]);
//$router->add("posts", ["controller" => "Posts", "action" => "index"]);
//$router->add("posts/new", ["controller" => "Posts", "action" => "new"]);
//$router->add('admin/{action}/{controller}');

// echo "<pre>";
// //var_dump($router->getRoutes());
// echo htmlspecialchars(print_r($router->getRoutes(), true));
// echo "</pre>";

// // Match the requested route
// $url = $_SERVER["QUERY_STRING"];

// if ($router->match($url)) {
//     echo "<pre>";
//     var_dump($router->getParams());
//     echo "</pre>";
// } else {
//     echo "No route found for url: " . $url;
// }

$router->dispatch($_SERVER["QUERY_STRING"]);