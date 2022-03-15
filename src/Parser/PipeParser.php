<?php

namespace Fastwf\Interpolation\Parser;

use Fastwf\Interpolation\Lexer\LD;
use Fastwf\Interpolation\Node\NodeInterface;
use Fastwf\Interpolation\Node\PipeNode;
use Fastwf\Interpolation\Api\Parser\AParser;
use Fastwf\Interpolation\Api\Exceptions\LexerException;

/**
 * Parser that allows to parse the pipe expression (a function call).
 * 
 * In expressions "%{ varName | split(',') }", the parser is able to parse " split(',') " sub section.
 */
class PipeParser extends AParser
{

    public function parse()
    {
        // Skip all spaces and expect a function name
        $this->lexer->skip(LD::T_WHITESPACE)
            ->expectToken(LD::T_VARIABLE);
        $name = $this->lexer->getCurrent();

        // Expect left_parenthese, pipe, end mark or eof
        $this->lexer->skip(LD::T_WHITESPACE);

        try
        {
            $this->lexer->expectToken(LD::T_LPAREN);

            $hasArguments = true;
        }
        catch (LexerException $e)
        {
            $hasArguments = false;
        }

        if ($hasArguments)
        {
            // Parse arguments
            $arguments = $this->parseArguments();

            // Expect the right parenthese
            $this->lexer->expectToken(LD::T_RPAREN);
        }
        else
        {
            $arguments = [];
        }

        return new PipeNode($name, $arguments);
    }

    /**
     * Parse all arguments to the next right parenthese.
     *
     * @return array<NodeInterface> the argument nodes.
     */
    protected function parseArguments()
    {
        $nodes = [];

        if (!$this->lexer->skip(LD::T_WHITESPACE)->look(LD::T_RPAREN))
        {
            // Parse the first argument
            \array_push($nodes, $this->parseArgument());

            while (
                !$this->lexer->isEndOfFile()
                    && !$this->lexer->skip(LD::T_WHITESPACE)->look(LD::T_RPAREN)
            )
            {
                // Expect an argument separator ','
                $this->lexer->expectToken(LD::T_COMMA);
                $this->lexer->skip(LD::T_WHITESPACE);

                // Expect an argument
                \array_push($nodes, $this->parseArgument());
            }
        }

        return $nodes;
    }

    /**
     * Expect a value or a variable name.
     *
     * @return NodeInterface The argument node.
     */
    protected function parseArgument()
    {
        return $this->lexer->expectToken(LD::T_NULL, LD::T_BOOLEAN, LD::T_NUMBER, LD::T_STRING, LD::T_VARIABLE)
            ->getNode($this->lexer->getCurrent());
    }

}
