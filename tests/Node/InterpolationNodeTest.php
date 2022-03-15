<?php

namespace Fastwf\Tests\Node;

use Fastwf\Interpolation\Node\InterpolationNode;
use Fastwf\Interpolation\Node\TextNode;
use PHPUnit\Framework\TestCase;

class InterpolationNodeTest extends TestCase
{

    /**
     * @covers Fastwf\Interpolation\Node\InterpolationNode
     * @covers Fastwf\Interpolation\Node\TextNode
     */
    public function testEvaluate()
    {
        $this->assertEquals(
            'Hello world!', 
            (new InterpolationNode([new TextNode('Hello '), new TextNode('world!')]))->evaluate(null)
        );
    }

}
