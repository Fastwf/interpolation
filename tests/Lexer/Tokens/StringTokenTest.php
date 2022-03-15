<?php

namespace Fastwf\Tests\Lexer\Tokens;

use PHPUnit\Framework\TestCase;
use Fastwf\Interpolation\Node\ValueNode;
use Fastwf\Interpolation\Lexer\Tokens\StringToken;

class StringTokenTest extends TestCase
{

    /**
     * @covers Fastwf\Interpolation\Api\Lexer\Token\AToken
     * @covers Fastwf\Interpolation\Node\ValueNode
     * @covers Fastwf\Interpolation\Lexer\Tokens\StringToken
     */
    public function testGetNode()
    {
        $token = new StringToken();
        $node = $token->getNode('"My string"');

        $this->assertInstanceOf(ValueNode::class, $node);

        $this->assertEquals('My string', $node->evaluate(null));
    }

    /**
     * @covers Fastwf\Interpolation\Api\Lexer\Token\AToken
     * @covers Fastwf\Interpolation\Lexer\Tokens\StringToken
     */
    public function testParseString()
    {
        $token = new StringToken();

        $this->assertEquals(
            "Bonjour l'\"Monde\" with \\ \\a \r\navec a => \141 => \x61 \n\e[34m\u{00A9} Fastwf\e[0m\n\t<",
            $token->parseString(
                "\"Bonjour l\\'\\\"Monde\\\" with \\\\ \\a \\r\\navec a => \\141 => \\x61 \\n\\e[34m\\u{00A9} Fastwf\\e[0m\\n\\t<\""
            )
        );
    }

}
