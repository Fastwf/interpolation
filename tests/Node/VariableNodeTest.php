<?php

namespace Fastwf\Tests\Node;

use PHPUnit\Framework\TestCase;
use Fastwf\Interpolation\Node\VariableNode;
use Fastwf\Interpolation\Api\Evaluation\Environment;

class VariableNodeTest extends TestCase
{

    /**
     * @covers Fastwf\Interpolation\Node\VariableNode
     * @covers Fastwf\Interpolation\Api\Evaluation\Environment
     */
    public function testEvaluate()
    {
        $env = new Environment();
        $env->setVariables(['hello' => 'Hello']);

        $this->assertEquals('Hello', (new VariableNode('hello'))->evaluate($env));
    }

}
