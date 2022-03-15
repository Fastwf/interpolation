<?php

namespace Fastwf\Tests\Lexer\Tokens;

use PHPUnit\Framework\TestCase;
use Fastwf\Interpolation\Node\ValueNode;
use Fastwf\Interpolation\Lexer\Tokens\NullToken;

class NullTokenTest extends TestCase
{

    /**
     * @covers Fastwf\Interpolation\Api\Lexer\Token\AToken
     * @covers Fastwf\Interpolation\Node\ValueNode
     * @covers Fastwf\Interpolation\Lexer\Tokens\NullToken
     */
    public function testGetNode()
    {
        $this->assertInstanceOf(ValueNode::class, (new NullToken())->getNode('true'));
    }

}
