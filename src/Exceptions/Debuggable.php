<?php


namespace Isofman\LaravelUtilities\Exceptions;


use Illuminate\Support\Arr;

/**
 * Trait Debuggable
 * @package Isofman\LaravelUtilities\Exceptions
 */
trait Debuggable
{
    /**
     * @return array
     */
    protected $meta = [];

    /**
     * @param $meta
     * @return static
     */
    public function with($meta)
    {
        $this->meta = $meta;
        return $this;
    }

    /**
     * @param $key
     * @param $value
     * @return static
     */
    public function put($key, $value)
    {
        $this->meta[$key] = $value;
        return $this;
    }

    /**
     * @param $key
     * @return mixed
     */
    public function get($key)
    {
        return Arr::get($this->meta, $key);
    }

    /**
     * @return array
     */
    public function getMeta()
    {
        return $this->meta;
    }
}
