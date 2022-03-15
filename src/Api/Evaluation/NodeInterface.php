<?php

namespace Fastwf\Interpolation\Api\Evaluation;

use Fastwf\Interpolation\Api\Evaluation\Environment;

interface NodeInterface
{

    /**
     * Evaluate the current node using the environment in parameter.
     *
     * @param Environment $environment
     * @return mixed the result evaluated.
     */
    public function evaluate($environment);

}
