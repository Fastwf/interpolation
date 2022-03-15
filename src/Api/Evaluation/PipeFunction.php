<?php

namespace Fastwf\Interpolation\Api\Evaluation;

use Fastwf\Interpolation\Api\Evaluation\PipeInterface;

/**
 * Implmentation that allows to delegate transform logic to a function or method.
 */
class PipeFunction implements PipeInterface
{

    /**
     * The function to call to transform the incomming value.
     *
     * @var Callable
     */
    private $callable;

    /**
     * Constructor.
     *
     * @param Callable $callable The transform implementation.
     */
    public function __construct($callable)
    {
        $this->callable = $callable;
    }

    public function transform($value, $arguments)
    {
        return call_user_func_array(
            $this->callable,
            array_merge([$value], $arguments)
        );
    }
}
