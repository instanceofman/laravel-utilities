<?php

namespace Isofman\LaravelUtilities\Random;


use Closure;
use InvalidArgumentException;

class Random
{
    public function format($value, $formatter = null)
    {
        if (is_string($formatter)) {
            return $formatter($value);
        } else if ($formatter instanceof Closure) {
            return $formatter($value);
        } else if (is_callable($formatter)) {
            return is_array($formatter) ? call_user_func($formatter, $value) : $formatter($value);
        } else {
            throw new InvalidArgumentException();
        }
    }

    public function string($length, $formatter = null): string
    {
        return $this->format(
            (new RandomHandler())->generate($length),
            $formatter
        );
    }

    public function numbers($length, $formatter = null): string
    {
        return $this->format(
            (new RandomHandler('123456789'))->generate($length),
            $formatter
        );
    }

    public function numbersWithZero($length, $formatter = null)
    {
        $str = (new RandomHandler('0123456789'))->generate($length-1);
        $str = rand(1, 9) . $str;
        return $this->format($str, $formatter);
    }
}
