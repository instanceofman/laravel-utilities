<?php

namespace Isofman\LaravelUtilities\Exceptions;

use RuntimeException as CoreRuntimeException;

/**
 * Class RuntimeException
 * @package Isofman\LaravelUtilities\Exceptions
 */
class FriendlyException extends CoreRuntimeException
{
    /**
     * @var bool
     */
    protected $silent = false;

    /**
     * @return $this
     */
    public function silent()
    {
        $this->silent = true;
        return $this;
    }

    /**
     * @return bool
     */
    public function shouldBeSilent()
    {
        return $this->silent;
    }

    public function toArray()
    {
        return [
            'int_code' => $this->getCode(),
            'message' => $this->getMessage()
        ];
    }
}