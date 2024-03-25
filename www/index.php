<?php 

$path = parse_url($_SERVER["REQUEST_URI"], PHP_URL_PATH);

require "src/router.php";

$router = new Router;

$segment = explode("/", $path);

$action = $segment[2];
$controller = $segment[1];

require "src/controllers/$controller.php";
$controller_object = new $controller;

$controller_object->$action();
