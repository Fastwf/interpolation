<?php

namespace Fastwf\Tests\Node;

use Fastwf\Interpolation\Node\TextNode;
use PHPUnit\Framework\TestCase;

class TextNodeTest extends TestCase
{

    /**
     * @covers Fastwf\Interpolation\Node\TextNode
     */
    public function testEvaluate()
    {
        $this->assertEquals('Hello ', (new TextNode('Hello '))->evaluate(null));
    }

}
