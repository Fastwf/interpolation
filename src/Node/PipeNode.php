<?php

namespace Fastwf\Interpolation\Node;

use Fastwf\Interpolation\Api\Evaluation\NodeInterface;
use Fastwf\Interpolation\Evaluation\Environment;
use Fastwf\Interpolation\Evaluation\PipeInterface;

class PipeNode implements NodeInterface
{

    private $name;

    private $arguments;
    private $evaluatedArguments;

    public function __construct($name, $arguments)
    {
        $this->name = $name;
        $this->arguments = $arguments;
    }

    /**
     * Try to find the pipe in environment.
     *
     * @param Environment $environment the evaluation environment.
     * @return PipeInterface the pipe interface found
     */
    public function evaluate($environment)
    {
        $this->evaluatedArguments = array_map(
            function ($arg) use ($environment) { return $arg->evaluate($environment); },
            $this->arguments
        );

        return $environment->getPipe($this->name);
    }
    
    public function transform($result, $environment)
    {
        $pipe = $this->evaluate($environment);

        return $pipe->transform($result, $this->evaluatedArguments);
    }

}
