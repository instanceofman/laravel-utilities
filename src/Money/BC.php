<?php


namespace Isofman\LaravelUtilities\Money;


/**
 * Class BC
 * @package Isofman\LaravelUtilities\Money
 * @method string add($left_operand, $right_operand, $scale = 0)
 * @method string comp($left_operand, $right_operand, $scale = 0)
 * @method string div($dividend, $divisor, $scale = 0)
 * @method string mod($dividend, $divisor, $scale = 0)
 * @method string mul($base, $exponent, $scale = 0)
 * @method string pow($base, $exponent, $scale = 0)
 * @method string powmod($base, $exponent, $modulus, $scale = 0)
 * @method string scale($scale)
 * @method string sqrt($operand, $scale = null)
 * @method string sub($left_operand, $right_operand, $scale = 0)
 */
class BC
{
    const METHODS = ['add', 'comp', 'div', 'mod', 'mul', 'pow', 'powmod', 'scale', 'sqrt', 'sub'];

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

        $name = 'bc'.$name;

        return call_user_func_array($name, $arguments);
    }
}