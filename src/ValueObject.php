<?php


namespace Isofman\LaravelUtilities;


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

    public function __toString()
    {
        return strval($this->getValue());
    }

    public function jsonSerialize()
    {
        return $this->getValue();
    }

    public function resolve($template, $formatter = null)
    {
        $value = is_null($formatter) ? $this->getValue() : call_user_func($formatter, $this->getValue());
        return sprintf($template, $value);
    }
}
