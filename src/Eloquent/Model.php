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
     * @param $processor
     */
    protected function processCatcher($processor) {
        if($processor instanceof Exception) {
            throw $processor;
        } else if (is_string($processor)) {
            $processor($this);
        } else if ($processor instanceof Closure) {
            $processor($this);
        } else if (is_callable($processor)) {
            is_array($processor) ? call_user_func($processor, $this) : $processor($this);
        } else {
            throw new InvalidArgumentException();
        }
    }

    /**
     * @param $processor
     * @return $this
     */
    public function catch($processor)
    {
        if(! $this instanceof NullModel) {
            return $this;
        }

        $this->processCatcher($processor);

        return $this;
    }
}