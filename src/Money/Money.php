<?php

namespace Isofman\LaravelUtilities\Money;

use Isofman\LaravelUtilities\ValueObject;
use Webmozart\Assert\Assert;

class Money extends ValueObject
{
    const VALUE_SCALE = 8;

    /**
    * @var BC
    */
    private static $bc = null;

    /**
     * @param $value
     * @return Money
     */
    public static function normalize($value)
    {
        return parent::normalize($value);
    }

    public function setValue($value)
    {
        $value = $this->castOperationValue($value);

        Assert::numeric($value);
        Assert::greaterThanEq($value, 0);

        $this->value = $value;
    }

    /**
     * @param mixed $scale
     * @return string
     */
    public function getValue($scale = self::VALUE_SCALE): string
    {
        Assert::numeric($scale);
        Assert::lessThanEq($scale, self::VALUE_SCALE);

        $format = '%0.9f';
        return $this->math()->mul(
            sprintf($format, $this->value), 1, $scale
        );
    }

    public function getSourceValue()
    {
        return $this->value;
    }

    /**
     * @param mixed $value
     * @return bool
     */
    public function equals($value)
    {
        $value = $this->castOperationValue($value);
        return $this->math()->comp($this->value, $value, self::VALUE_SCALE) === 0;
    }

    public function lessThan($value)
    {
        $value = $this->castOperationValue($value);
        return $this->math()->comp($this->value, $value, self::VALUE_SCALE) < 0;
    }

    public function lessThanOrEqual($value)
    {
        $value = $this->castOperationValue($value);
        return $this->lessThan($value) || $this->equals($value);
    }

    public function greaterThan($value)
    {
        $value = $this->castOperationValue($value);
        return $this->math()->comp($this->value, $value, self::VALUE_SCALE) > 0;
    }

    public function greaterThanOrEqual($value)
    {
        $value = $this->castOperationValue($value);
        return $this->greaterThan($value) || $this->equals($value);
    }

    /**
     * @return Money
     */
    public function copy()
    {
        return clone $this;
    }

    /**
     * @param $value
     * @return Money
     */
    public function add($value)
    {
        $value = $this->castOperationValue($value);
        $this->value = $this->math()->add($this->value, $value, self::VALUE_SCALE + 1);
        return $this;
    }

    /**
     * @param $value
     * @return Money
     */
    public function sub($value)
    {
        $value = $this->castOperationValue($value);
        $this->value = $this->math()->sub($this->value, $value, self::VALUE_SCALE + 1);
        return $this;
    }

    /**
     * @param $value
     * @return Money
     */
    public function mul($value)
    {
        $value = $this->castOperationValue($value);
        $this->value = $this->math()->mul($this->value, $value, self::VALUE_SCALE + 1);
        return $this;
    }

    /**
     * @param $value
     * @return Money
     */
    public function div($value)
    {
        $value = $this->castOperationValue($value);
        $this->value = $this->math()->div($this->value, $value, self::VALUE_SCALE + 1);
        return $this;
    }

    protected function castOperationValue($value)
    {
        if($value instanceof Money) {
            return $value->getSourceValue();
        } else {
            Assert::numeric($value);
            $format = '%0.9f';
            return $this->math()->mul(sprintf($format, $value), 1, (self::VALUE_SCALE + 1));
        }
    }

    /**
    * @return BC
    */
    protected function math()
    {
        if (is_null(self::$bc)) {
            self::$bc = new BC;
        }

        return self::$bc;
    }
}
