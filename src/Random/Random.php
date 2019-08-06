<?php

namespace Isofman\LaravelUtilities\Random;


class Random
{
    public function tap($value, \Closure $formatter = null)
    {
        if ($formatter) {
            return $formatter($value);
        }

        return $value;
    }

    public function string($length, \Closure $formatter = null): string
    {
        return $this->tap((new RandomHandler())->generate($length), $formatter);
    }

    public function numbers($length, \Closure $formatter = null): string
    {
        return $this->tap((new RandomHandler('123456789'))->generate($length), $formatter);
    }

    public function numbersWithZero($length, \Closure $formatter = null)
    {
        $str = (new RandomHandler('0123456789'))->generate($length-1);
        $str = rand(1, 9) . $str;
        return $this->tap($str, $formatter);
    }
}
