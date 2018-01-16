<?php

namespace Core;

/**
 * Error and exception handler
 */
class Error
{
    /**
     * Error handler.
     * Convert all errors to Exceptions by throwing and ErrorException
     * @param int $level Error level
     * @param string $message Error message
     * @param string $file File name the error was raised in
     * @param int $line Line number in the file
     *
     * @return void
     */
    public static function errorHandler($level, $message, $file, $line)
    {
        if (error_reporting() !== 0) {
            throw new \ErrorException($message, 0, $level, $file, $line);
        }
    }

    /**
     * Exception handler
     *
     * @param Exception $exception The Exception
     *
     * @return void
     */
    public static function exceptionHandler($exception)
    {
        // Code is 404 (not foune) or 500 (general error)
        $code = $exception->getCode();
        if ($code !== 404) {
            $code = 500;
        }

        http_response_code($code);

        if (\App\Config::DISPLAY_ERRORS) {
            echo '<h1>Fatal error</h1>';
            echo '<p>Uncaught exception : "' . get_class($exception) . '"</p>';
            echo '<p>Message : "' . $exception->getMessage() . '"</p>';
            echo '<p>Stack trace : <pre>' . $exception->getTraceAsString() . '</pre></p>';
            echo '<p>Thrown in "' . $exception->getFile() . '" on line ' . $exception->getLine() . '</p>';
        } else {
            $log = dirname(__DIR__) . '/logs/error_' . date('Y-m-d') . '.log';
            ini_set('error_log', $log);

            $message = 'Uncaught exception : "' . get_class($exception) . '""';
            $message .= ' with message : "' . $exception->getMessage() . '"';
            $message .= "\n";
            $message .= 'Stack trace : ' . $exception->getTraceAsString();
            $message .= "\n";
            $message .= 'Thrown in "' . $exception->getFile() . '" on line ' . $exception->getLine();
            $message .= "\n";

            error_log($message);

            View::renderTemplate($code . '.html');
/*
            if ($code === 404) {
                echo '<h1>Page not found.</h1>';
            } else {
                echo '<h1>An error occurred.</h1>';
            }
*/

        }
    }
}
