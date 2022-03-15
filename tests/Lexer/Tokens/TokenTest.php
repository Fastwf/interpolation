<?php

namespace Fastwf\Tests\Lexer\Tokens;

use PHPUnit\Framework\TestCase;
use Fastwf\Interpolation\Node\ValueNode;
use Fastwf\Interpolation\Lexer\Tokens\Token;

class TokenTest extends TestCase
{

    /**
     * @covers Fastwf\Interpolation\Api\Lexer\Token\AToken
     * @covers Fastwf\Interpolation\Node\ValueNode
     * @covers Fastwf\Interpolation\Lexer\Tokens\Token
     */
    public function testGetNode()
    {
        $this->assertInstanceOf(ValueNode::class, (new Token('', ValueNode::class))->getNode('true'));
    }

    /**
     * @covers Fastwf\Interpolation\Api\Lexer\Token\AToken
     * @covers Fastwf\Interpolation\Lexer\Tokens\Token
     */
    public function testGetNodeNull()
    {
        $this->assertNull((new Token('', null))->getNode('true'));
    }

}
