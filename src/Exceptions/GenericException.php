<?php


namespace Isofman\LaravelUtilities\Exceptions;


use Throwable;

/**
 * Class GenericException
 * @package Isofman\LaravelUtilities\Exceptions
 */
class GenericException extends RuntimeException
{
    /**
     * GenericException constructor.
     * @param string $message
     * @param int $code
     * @param Throwable|null $previous
     */
    public function __construct($message = "", $code = 0, Throwable$previous = null)
    {
        parent::__construct($message, $code, $previous);
    }

    /**
     * @param string $message
     * @return static
     */
    public static function short($message = "")
    {
        return new static($message);
    }

    /**
     * @param string $message
     * @param int $code
     * @param Throwable|null $previous
     * @return static
     */
    public static function long($message = "", $code = 0, Throwable $previous = null)
    {
        return new static($message, $code, $previous);
    }
}