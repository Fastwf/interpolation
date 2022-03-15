<?php

namespace Fastwf\Interpolation\Node;

use Fastwf\Interpolation\Api\Evaluation\NodeInterface;

class InterpolationNode implements NodeInterface
{

    /**
     * The array of nodes that compose the interpolated message of nodes.
     *
     * @var array<NodeInterface>
     */
    protected $nodes;

    public function __construct($nodes)
    {
        $this->nodes = $nodes;
    }

    public function evaluate($environment)
    {
        $message = $this->nodes[0]->evaluate($environment);

        /** @var NodeInterface */
        foreach (array_slice($this->nodes, 1) as $node)
        {
            $message .= $node->evaluate($environment);
        }

        return $message;
    }

}
