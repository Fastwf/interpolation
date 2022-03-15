<?php

namespace Fastwf\Tests\Api\Parser;

use PHPUnit\Framework\TestCase;
use Fastwf\Interpolation\Api\Lexer\Lexer;
use Fastwf\Interpolation\Api\Parser\ParserPool;
use Fastwf\Interpolation\Parser\InterpolatorParser;

class ParserPoolTest extends TestCase
{

    /**
     * @covers Fastwf\Interpolation\Api\Lexer\Lexer
     * @covers Fastwf\Interpolation\Api\Parser\ParserPool
     */
    public function testGetLexer()
    {
        $lexer = new Lexer();
        $pool = new ParserPool($lexer);

        $this->assertEquals($lexer, $pool->getLexer());
    }

    /**
     * @covers Fastwf\Interpolation\Api\Lexer\Lexer
     * @covers Fastwf\Interpolation\Api\Parser\ParserPool
     * @covers Fastwf\Interpolation\Api\Parser\AParser
     * @covers Fastwf\Interpolation\Parser\InterpolatorParser
     */
    public function testGet()
    {
        $lexer = new Lexer();
        $pool = new ParserPool($lexer);

        $parser = $pool->get(InterpolatorParser::class);

        $this->assertSame($parser, $pool->get(InterpolatorParser::class));
    }

}
