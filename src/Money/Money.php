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
        if($value instanceof Money) {
            $value = $value->getValue();
        }
        Assert::numeric($value);
        Assert::greaterThanEq($value, 0);

        $format = '%0.9f';
        $value = $this->math()->bcadd(sprintf($format, $value), 1, self::VALUE_SCALE);
        $this->value = $value;
    }

    /**
     * @param mixed $scale
     * @return string
     */
    public function getValue($scale = null): string
    {
        if (!is_null($scale)) {
            $scale = self::VALUE_SCALE;
        }

        Assert::numeric($scale);
        Assert::lessThanEq($scale, self::VALUE_SCALE);

        $format = '%0.9f';
        return $this->math()->bcmul(
            sprintf($format, $this->value), 1, $scale
        );
    }

    /**
     * @param mixed $value
     * @return bool
     */
    public function equals($value)
    {
        $value = $this->castOperationValue($value);
        return $this->math()->bccomp($this->value, $value, self::VALUE_SCALE) === 0;
    }

    public function lessThan($value)
    {
        $value = $this->castOperationValue($value);
        return $this->math()->bccomp($this->value, $value, self::VALUE_SCALE) < 0;
    }

    public function lessThanOrEqual($value)
    {
        $value = $this->castOperationValue($value);
        return $this->lessThan($value) || $this->equals($value);
    }

    public function greaterThan($value)
    {
        $value = $this->castOperationValue($value);
        return $this->math()->bccomp($this->value, $value, self::VALUE_SCALE) > 0;
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
        $this->value = $this->math()->bcadd($this->value, $value, self::VALUE_SCALE);
        return $this;
    }

    /**
     * @param $value
     * @return Money
     */
    public function sub($value)
    {
        $value = $this->castOperationValue($value);
        $this->value = $this->math()->bcsub($this->value, $value, self::VALUE_SCALE);
        return $this;
    }

    /**
     * @param $value
     * @return Money
     */
    public function mul($value)
    {
        $value = $this->castOperationValue($value);
        $this->value = $this->math()->bcmul($this->value, $value, self::VALUE_SCALE);
        return $this;
    }

    /**
     * @param $value
     * @return Money
     */
    public function div($value)
    {
        $value = $this->castOperationValue($value);
        $this->value = $this->math()->bcdiv($this->value, $value, self::VALUE_SCALE);
        return $this;
    }

    protected function castOperationValue($value)
    {
        if($value instanceof Money) {
            return $value->getValue();
        } else {
            Assert::numeric($value);
            $format = '%0.9f';
            return $this->math()->bcmul(sprintf($format, $value), 1, self::VALUE_SCALE);
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
