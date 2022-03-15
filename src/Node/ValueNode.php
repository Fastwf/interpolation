<?php

namespace Fastwf\Interpolation\Node;

use Fastwf\Interpolation\Api\Evaluation\NodeInterface;

class ValueNode implements NodeInterface
{

    protected $value;

    public function __construct($value)
    {
        $this->value = $value;
    }

    public function evaluate($environment)
    {
        return $this->value;
    }

}
