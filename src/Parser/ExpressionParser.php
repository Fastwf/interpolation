<?php

namespace Fastwf\Interpolation\Parser;

use Fastwf\Interpolation\Lexer\LD;
use Fastwf\Interpolation\Api\Parser\AParser;
use Fastwf\Interpolation\Node\ExpressionNode;
use Fastwf\Interpolation\Api\Exceptions\LexerException;

/**
 * Parser that allows to parse expression inside expression mark.
 * 
 * For the template "Hello %{ name | uppercase }!", the parser can parse the subsection " name | uppercase ".
 */
class ExpressionParser extends AParser
{

    public function parse()
    {
        // Skip all white spaces
        $this->lexer->skip(LD::T_WHITESPACE, true);

        // Expect  a value (null, true, false, number, string) or variable name
        $expression = new ExpressionNode(
            $this->lexer->expectToken(LD::T_NULL, LD::T_BOOLEAN, LD::T_NUMBER, LD::T_STRING, LD::T_VARIABLE)
                ->getNode($this->lexer->getCurrent())
        );

        $hasPipe = true;
        while (!$this->lexer->isEndOfFile() && $hasPipe)
        {
            // Skip all white spaces
            $this->lexer->skip(LD::T_WHITESPACE, true);

            // If there is a pipe
            try
            {
                $this->lexer->expectToken(LD::T_PIPE);
            }
            catch (LexerException $e)
            {
                // The next token is not pipe, stop the loop
                $hasPipe = false;
            }

            if ($hasPipe)
            {
                // There is a pipe char, parse the pipe expression
                $expression->pipe(
                    $this->pool
                        ->get(PipeParser::class)
                        ->parse()
                );
            }
        }

        return $expression;
    }

}
