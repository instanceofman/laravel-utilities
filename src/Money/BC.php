<?php


namespace Isofman\LaravelUtilities\Money;


/**
 * Class BC
 * @package Isofman\LaravelUtilities\Money
 * @method string bcadd($left_operand, $right_operand, $scale = 0)
 * @method string bccomp($left_operand, $right_operand, $scale = 0)
 * @method string bcdiv($dividend, $divisor, $scale = 0)
 * @method string bcmod($dividend, $divisor, $scale = 0)
 * @method string bcmul($base, $exponent, $scale = 0)
 * @method string bcpow($base, $exponent, $scale = 0)
 * @method string bcpowmod($base, $exponent, $modulus, $scale = 0)
 * @method string bcscale($scale)
 * @method string bcsqrt($operand, $scale = null)
 * @method string bcsub($left_operand, $right_operand, $scale = 0)
 */
class BC
{
    const METHODS = ['bcadd', 'bccomp', 'bcdiv', 'bcmod', 'bcmul', 'bcpow', 'bcpowmod', 'bcscale', 'bcsqrt', 'bcsub'];

    /**
     * @param $name
     * @param $arguments
     * @return mixed
     */
    public function __call($name, $arguments)
    {
        if (!in_array($name, self::METHODS)) {
            throw new \InvalidArgumentException('Invalid method');
        }

        return call_user_func_array($name, $arguments);
    }
}