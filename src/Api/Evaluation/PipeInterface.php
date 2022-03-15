<?php

namespace Fastwf\Interpolation\Api\Evaluation;

/**
 * Definition of pipe interpolator.
 */
interface PipeInterface
{

    /**
     * Perform value transformation.
     *
     * @param mixed $value the value to transform.
     * @param array<int,mixed> $arguments the pipe arguments to use for transformation.
     * @return mixed the value transformed.
     */
    public function transform($value, $arguments);

}
