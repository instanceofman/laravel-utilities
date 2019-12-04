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
     * @var string
     */
    protected $stringCode;

    /**
     * @var string
     */
    protected $context;

    /**
     * SpecificException constructor.
     * @param $code
     * @param string $context
     * @param string $message
     * @param Throwable|null $previous
     * @param int $intCode
     */
    public function __construct($code, string $context = 'default', $message = "", Throwable $previous = null, $intCode = 0)
    {
        parent::__construct($message, $intCode, $previous);

        $this->stringCode = $code;
        $this->context = $context;
    }

    /**
     * @return mixed
     */
    protected abstract static function getPredefinedStringCode();

    /**
     * @param null $code
     * @param string $message
     * @param Throwable|null $previous
     * @param int $intCode
     * @return static
     */
    public static function raise($code = null, $message = "", Throwable $previous = null, $intCode = 0)
    {
        return new static($code ?? static::getPredefinedStringCode(), null, $message, $previous, $intCode);
    }

    /**
     * @param string $context
     * @return $this
     */
    public function context(string $context)
    {
        $this->context = $context;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getStringCode()
    {
        return $this->stringCode;
    }

    public function toArray()
    {
        return [
            'code' => $this->getStringCode(),
            'int_code' => $this->getCode(),
            'message' => $this->getMessage(),
            'context' => $this->context,
        ];
    }
}