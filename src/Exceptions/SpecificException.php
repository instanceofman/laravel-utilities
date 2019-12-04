<?php


namespace Isofman\LaravelUtilities\Exceptions;

use Throwable;

/**
 * Class SpecificException
 * @package Isofman\LaravelUtilities\Exceptions
 */
class SpecificException extends RuntimeException
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
     * @param $code
     * @param string $message
     * @return $this
     */
    public function short($code, $message = "")
    {
        return new static($code, $message);
    }

    /**
     * @param $code
     * @param string $message
     * @param Throwable|null $previous
     * @param int $intCode
     * @return $this
     */
    public function long($code, $message = "", Throwable $previous = null, $intCode = 0)
    {
        return new static($code, $message, $previous, $intCode);
    }

    /**
     * @return mixed
     */
    public function getStringCode()
    {
        return $this->stringCode;
    }
}