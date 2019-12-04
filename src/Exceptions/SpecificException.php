<?php


namespace Isofman\LaravelUtilities\Exceptions;

use Throwable;

/**
 * Class SpecificException
 * @package Isofman\LaravelUtilities\Exceptions
 */
abstract class SpecificException extends FriendlyException
{
    /**
     * @var
     */
    protected $stringCode;

    /**
     * SpecificException constructor.
     * @param $code
     * @param string $message
     * @param Throwable|null $previous
     * @param int $intCode
     */
    public function __construct($code, $message = "", Throwable $previous = null, $intCode = 0)
    {
        parent::__construct($message, $intCode, $previous);

        $this->stringCode = $code;
    }

    /**
     * @return mixed
     */
    protected abstract static function getPredefinedStringCode();

    /**
     * @param string $message
     * @param Throwable|null $previous
     * @param int $intCode
     * @return static
     */
    public static function raise($message = "", Throwable $previous = null, $intCode = 0)
    {
        return new static(static::getPredefinedStringCode(), $message, $previous, $intCode);
    }

    /**
     * @return mixed
     */
    public function getStringCode()
    {
        return $this->stringCode;
    }
}