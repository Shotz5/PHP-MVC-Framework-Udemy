<?php
declare(strict_types=1);

$show_errors = false;
ini_set("display_errors", (int)$show_errors);
ini_set("log_errors", 1);
ini_set("error_log", "/var/www/html/logs/error_log");

spl_autoload_register(function (string $class_name) {
    require "src/" . str_replace("\\", "/", $class_name) . ".php";
});

set_error_handler("Framework\ErrorHandler::handleError");
set_exception_handler("Framework\ErrorHandler::handleException");

$path = parse_url($_SERVER["REQUEST_URI"], PHP_URL_PATH);

if ($path === false) {
    throw new UnexpectedValueException("Malformed url: {$_SERVER["REQUEST_URI"]}");
}

$router = require "config/routes.php";
$container = require "config/services.php";

$dispatcher = new Framework\Dispatcher($router, $container);
$dispatcher->handle($path);
