<?php

namespace Fastwf\Tests;

use DateTime;
use Fastwf\Interpolation\Api\Evaluation\Environment;
use PHPUnit\Framework\TestCase;
use Fastwf\Interpolation\LexInterpolator;
use Fastwf\Interpolation\Api\Evaluation\PipeFunction;
use Fastwf\Interpolation\Api\Exceptions\LexerException;

class LexInterpolatorTest extends TestCase
{

    /**
     * @covers Fastwf\Interpolation\Api\Evaluation\Environment
     * @covers Fastwf\Interpolation\Api\Evaluation\PipeFunction
     * @covers Fastwf\Interpolation\Api\Lexer\Lexer
     * @covers Fastwf\Interpolation\Api\Lexer\Token\AToken
     * @covers Fastwf\Interpolation\Api\Parser\AParser
     * @covers Fastwf\Interpolation\Api\Parser\ParserPool
     * @covers Fastwf\Interpolation\Lexer\Tokens\BooleanToken
     * @covers Fastwf\Interpolation\Lexer\Tokens\NullToken
     * @covers Fastwf\Interpolation\Lexer\Tokens\NumberToken
     * @covers Fastwf\Interpolation\Lexer\Tokens\StringToken
     * @covers Fastwf\Interpolation\Lexer\Tokens\Token
     * @covers Fastwf\Interpolation\Lexer\Tokens\VariableToken
     * @covers Fastwf\Interpolation\LexInterpolator
     * @covers Fastwf\Interpolation\Node\ExpressionNode
     * @covers Fastwf\Interpolation\Node\InterpolationNode
     * @covers Fastwf\Interpolation\Node\PipeNode
     * @covers Fastwf\Interpolation\Node\TextNode
     * @covers Fastwf\Interpolation\Node\ValueNode
     * @covers Fastwf\Interpolation\Node\VariableNode
     * @covers Fastwf\Interpolation\Parser\ExpressionParser
     * @covers Fastwf\Interpolation\Parser\InterpolatorParser
     * @covers Fastwf\Interpolation\Parser\PipeParser
     * @covers Fastwf\Interpolation\Utils\RegexUtil
     */
    public function testInterpolate()
    {
        $itpr = new LexInterpolator();

        $template = \file_get_contents(__DIR__.'/../resources/safe-template.txt');
        $expected = \file_get_contents(__DIR__.'/../resources/safe-expected.txt');

        $env = $itpr->getEnvironment();

        $env->setPipe('date', new PipeFunction(function ($date, $format) { return $date->format($format); }));
        $env->setPipe('join', new PipeFunction(function ($list, $glue, $start = null, $end = null) {
            return ($start ?: '')
                . implode($glue, $list)
                . ($end ?: '');
        }));
        $env->setPipe('sort', new PipeFunction(function ($list) {
            $copy = $list;
            sort($copy);
            return $copy;
        }));

        $this->assertEquals(
            $expected,
            $itpr->interpolate($template, ['value' => 'VALUE', 'date' => new DateTime('1995-04-26 00:00:00.000'), 'list' => [1, 3, 2]])
        );
    }

    /**
     * @covers Fastwf\Interpolation\Api\Evaluation\Environment
     * @covers Fastwf\Interpolation\Api\Lexer\Lexer
     * @covers Fastwf\Interpolation\Api\Lexer\Token\AToken
     * @covers Fastwf\Interpolation\Api\Parser\AParser
     * @covers Fastwf\Interpolation\Api\Parser\ParserPool
     * @covers Fastwf\Interpolation\Lexer\Tokens\BooleanToken
     * @covers Fastwf\Interpolation\Lexer\Tokens\NullToken
     * @covers Fastwf\Interpolation\Lexer\Tokens\NumberToken
     * @covers Fastwf\Interpolation\Lexer\Tokens\StringToken
     * @covers Fastwf\Interpolation\Lexer\Tokens\Token
     * @covers Fastwf\Interpolation\Lexer\Tokens\VariableToken
     * @covers Fastwf\Interpolation\LexInterpolator
     * @covers Fastwf\Interpolation\Node\ExpressionNode
     * @covers Fastwf\Interpolation\Node\TextNode
     * @covers Fastwf\Interpolation\Node\VariableNode
     * @covers Fastwf\Interpolation\Parser\ExpressionParser
     * @covers Fastwf\Interpolation\Parser\InterpolatorParser
     * @covers Fastwf\Interpolation\Utils\RegexUtil
     */
    public function testParseError()
    {
        $this->expectException(LexerException::class);

        $itpr = new LexInterpolator();
        $itpr->setEnvironment(new Environment());

        $itpr->interpolate("Another test with bad expression interpolation %{", ['value' => 'VALUE']);
    }

}
