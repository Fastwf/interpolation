<?php

namespace Fastwf\Tests\Lexer\Tokens;

use PHPUnit\Framework\TestCase;
use Fastwf\Interpolation\Node\VariableNode;
use Fastwf\Interpolation\Lexer\Tokens\VariableToken;

class VariableTokenTest extends TestCase
{

    /**
     * @covers Fastwf\Interpolation\Api\Lexer\Token\AToken
     * @covers Fastwf\Interpolation\Node\VariableNode
     * @covers Fastwf\Interpolation\Lexer\Tokens\VariableToken
     */
    public function testGetNode()
    {
        $this->assertInstanceOf(VariableNode::class, (new VariableToken())->getNode('true'));
    }

}
