<?php

namespace Fastwf\Interpolation\Node;

use Fastwf\Interpolation\Api\Evaluation\NodeInterface;

class VariableNode implements NodeInterface
{

    protected $varname;

    public function __construct($varname)
    {
        $this->varname = $varname;
    }

    public function evaluate($environment)
    {
        return $environment->getVariable($this->varname);
    }

}
