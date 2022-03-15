<?php

namespace Fastwf\Tests\Lexer\Tokens;

use Fastwf\Interpolation\Lexer\Tokens\BooleanToken;
use Fastwf\Interpolation\Node\ValueNode;
use PHPUnit\Framework\TestCase;

class BooleanTokenTest extends TestCase
{

    /**
     * @covers Fastwf\Interpolation\Api\Lexer\Token\AToken
     * @covers Fastwf\Interpolation\Node\ValueNode
     * @covers Fastwf\Interpolation\Lexer\Tokens\BooleanToken
     */
    public function testGetNode()
    {
        $this->assertInstanceOf(ValueNode::class, (new BooleanToken())->getNode('true'));
    }

}
