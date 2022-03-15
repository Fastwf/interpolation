<?php

namespace Fastwf\Tests\Lexer\Tokens;

use PHPUnit\Framework\TestCase;
use Fastwf\Interpolation\Node\ValueNode;
use Fastwf\Interpolation\Lexer\Tokens\NumberToken;

class NumberTokenTest extends TestCase
{

    /**
     * @covers Fastwf\Interpolation\Api\Lexer\Token\AToken
     * @covers Fastwf\Interpolation\Node\ValueNode
     * @covers Fastwf\Interpolation\Lexer\Tokens\NumberToken
     */
    public function testGetNode()
    {
        $token = new NumberToken();
        $node = $token->getNode('3');

        $this->assertInstanceOf(ValueNode::class, $node);

        $this->assertEquals(3, $node->evaluate(null));
        $this->assertEquals(3.14, $token->getNode('3.14')->evaluate(null));
    }

}
