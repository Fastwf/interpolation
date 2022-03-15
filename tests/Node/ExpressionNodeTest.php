<?php

namespace Fastwf\Tests\Node;

use PHPUnit\Framework\TestCase;
use Fastwf\Interpolation\Node\ExpressionNode;
use Fastwf\Interpolation\Api\Evaluation\Environment;
use Fastwf\Interpolation\Api\Evaluation\PipeFunction;
use Fastwf\Interpolation\Node\PipeNode;
use Fastwf\Interpolation\Node\ValueNode;

class ExpressionNodeTest extends TestCase
{

    /**
     * @covers Fastwf\Interpolation\Api\Evaluation\Environment
     * @covers Fastwf\Interpolation\Api\Evaluation\PipeFunction
     * @covers Fastwf\Interpolation\Node\PipeNode
     * @covers Fastwf\Interpolation\Node\ValueNode
     * @covers Fastwf\Interpolation\Node\ExpressionNode
     */
    public function testEvaluate()
    {
        $env = new Environment();

        $env->setPipe('join', new PipeFunction(function ($value, $glue) { return implode($glue, $value); }));
        
        $node = new ExpressionNode(new ValueNode([1, 2, 3]));
        $node->pipe(new PipeNode('join', [new ValueNode(', ')]));

        $this->assertEquals('1, 2, 3', $node->evaluate($env));
    }

}
