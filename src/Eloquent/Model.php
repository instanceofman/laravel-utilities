<?php


namespace Isofman\LaravelUtilities\Eloquent;

use Closure;
use Exception;
use Illuminate\Database\Eloquent\Model as Eloquent;
use InvalidArgumentException;

/**
 * Class Model
 * @package Isofman\LaravelUtilities\Eloquent
 */
class Model extends Eloquent
{
    /**
     * @param \Illuminate\Database\Query\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder|Eloquent|Builder
     */
    public function newEloquentBuilder($query)
    {
        return new Builder($query);
    }

    /**
     * @param mixed $handle
     */
    protected function process($handle) {
        if($handle instanceof Exception) {
            throw $handle;
        } else if (is_string($handle)) {
            $handle($this);
        } else if ($handle instanceof Closure) {
            $handle($this);
        } else if (is_callable($handle)) {
            is_array($handle) ? call_user_func($handle, $this) : $handle($this);
        } else {
            throw new InvalidArgumentException();
        }
    }

    /**
     * @param mixed $handle
     * @return Model
     */
    public function catch($handle)
    {
        if(! $this instanceof NullModel) {
            return $this;
        }

        $this->process($handle);

        return $this;
    }

    /**
     * @param mixed $handle
     * @return Model
     */
    public function then($handle)
    {
        if($this instanceof NullModel) {
            return $this;
        }

        $this->process($handle);

        return $this;
    }

    /**
     * @param mixed $handle
     * @return Model
     */
    public function known($handle)
    {
        return $this->then($handle);
    }

    /**
     * @param mixed $handle
     * @return Model
     */
    public function unknown($handle)
    {
        return $this->catch($handle);
    }
}
