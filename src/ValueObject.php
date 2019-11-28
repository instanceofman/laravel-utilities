<?php


namespace Isofman\LaravelUtilities;


use Closure;
use InvalidArgumentException;

class ValueObject implements \JsonSerializable
{
    protected $value;

    public function getValue()
    {
        return $this->value;
    }

    public function setValue($value)
    {
        $this->value = $value;
    }

    public function equals($value)
    {
        $value = $value instanceof ValueObject ? $value->getValue() : $value;
        return $this->value === $value;
    }

    public function is($value)
    {
        return $this->equals($value);
    }

    public function isNot($value)
    {
        return $this->notEquals($value);
    }

    public function in(array $values)
    {
        return in_array($this->getValue(), $values);
    }

    public function isOneOf(array $collection)
    {
        return in_array($this->value, $collection);
    }

    public function notEquals($value)
    {
        return !$this->equals($value);
    }

    public static function normalize($value)
    {
        if($value instanceof ValueObject) {
            $value = $value->getValue();
        }

        $instance = new static;
        $instance->setValue($value);
        return $instance;
    }

    /**
     * @return $this
     */
    public function clone()
    {
        return clone $this;
    }

    public function use()
    {
        return $this->clone();
    }

    public function __toString()
    {
        return strval($this->getValue());
    }

    public function jsonSerialize()
    {
        return $this->getValue();
    }

    protected function executeFormatter($processor, $value)
    {
        if (is_string($processor)) {
            return $processor($value);
        } else if ($processor instanceof Closure) {
            return $processor($value);
        } else if (is_callable($processor)) {
            return is_array($processor) ? call_user_func($processor, $value) : $processor($value);
        } else {
            throw new InvalidArgumentException();
        }
    }

    public function resolve($template, $formatter = null)
    {
        $value = is_null($formatter) ? $this->getValue() : $this->executeFormatter($formatter, $this->getValue());
        return sprintf($template, $value);
    }
}
