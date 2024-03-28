<?php
declare(strict_types=1);

namespace Framework;

use ErrorException;
use Throwable;

class ErrorHandler
{
    public static function handleError(
        int $errorno,
        string $errorstr,
        string $errfile,
        int $errline
    ): bool
    {
        throw new ErrorException($errorstr, 0, $errorno, $errfile, $errline);
    }

    public static function handleException(Throwable $exception): void
    {
        if ($exception instanceof \Framework\Exceptions\PageNotFoundException) {
            http_response_code(404);
    
            $template = "404.php";
        } else {
            http_response_code(500);
    
            $template = "500.php";
        }
    
        if (ini_get("display_errors") === false) {
            require "views/$template";
        } else {
            throw $exception;
        }
    }
}