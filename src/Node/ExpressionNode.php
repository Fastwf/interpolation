<?php

namespace Fastwf\Interpolation\Node;

use Fastwf\Interpolation\Node\PipeNode;
use Fastwf\Interpolation\Api\Evaluation\NodeInterface;

/**
 * The expression node allows to evaluate a complex expression and transform the result thanks to pipe transforms.
 */
class ExpressionNode implements NodeInterface
{

    protected $pipes = [];

    /**
     * The main node to evaluate before calling pipe.
     *
     * @var NodeInterface
     */
    protected $node;

    public function __construct($node)
    {
        $this->node = $node;
    }

    public function evaluate($environment)
    {
        $result = $this->node->evaluate($environment);

        /** @var PipeNode */
        foreach ($this->pipes as $pipe) {
            $result = $pipe->transform($result, $environment);
        }

        return $result;
    }

    /**
     * Add pipe transform to the main node.
     *
     * @param PipeNode $node the pipe node to chain.
     * @return $this the current expression node
     */
    public function pipe($node)
    {
        array_push($this->pipes, $node);

        return $this;
    }

}
