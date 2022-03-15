<?php

namespace Fastwf\Interpolation\Parser;

use Fastwf\Interpolation\Lexer\LD;
use Fastwf\Interpolation\Node\TextNode;
use Fastwf\Interpolation\Api\Parser\AParser;
use Fastwf\Interpolation\Node\ExpressionNode;
use Fastwf\Interpolation\Node\InterpolationNode;
use Fastwf\Interpolation\Api\Exceptions\LexerException;

/**
 * Parser that allows to interpolate the source.
 * 
 * The parser detect interpolation mark for latter interpolation thanks to evaluation process.
 */
class InterpolatorParser extends AParser
{

    public function parse()
    {
        $nodes = [];

        // Try to parse the content using lexer
        while (!$this->lexer->isEndOfFile())
        {
            // Go to the next interpolation mark
            $hasExpression = $this->lexer->moveTo(LD::T_LMARK, true);

            // Add the text before the mark or the end of file if the text is not empty
            $text = $this->lexer->getCurrent();
            if ($text)
            {
                array_push($nodes, new TextNode($text));
            }

            if ($hasExpression)
            {
                // Parse the next tokens like an expression
                array_push($nodes, $this->parseExpression());

                $this->lexer->expectToken(LD::T_RMARK);
            }
        }

        return isset($nodes[1]) ? new InterpolationNode($nodes) : $nodes[0];
    }

    /**
     * Parse the expression inside interpolation mark.
     *
     * @return ExpressionNode
     */
    private function parseExpression()
    {
        if ($this->lexer->isEndOfFile())
        {
            throw new LexerException("Syntax error (unclosed interpolation mark)");
        }

        return $this->pool
            ->get(ExpressionParser::class)
            ->parse();
    }

}
