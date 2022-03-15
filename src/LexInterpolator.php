<?php

namespace Fastwf\Interpolation;

use Fastwf\Interpolation\Lexer\LD;
use Fastwf\Interpolation\Api\Lexer\Lexer;
use Fastwf\Interpolation\Utils\RegexUtil;
use Fastwf\Interpolation\Lexer\Tokens\Token;
use Fastwf\Interpolation\InterpolatorInterface;
use Fastwf\Interpolation\Lexer\Tokens\NullToken;
use Fastwf\Interpolation\Lexer\Tokens\NumberToken;
use Fastwf\Interpolation\Lexer\Tokens\StringToken;
use Fastwf\Interpolation\Lexer\Tokens\BooleanToken;
use Fastwf\Interpolation\Parser\InterpolatorParser;
use Fastwf\Interpolation\Api\Evaluation\Environment;
use Fastwf\Interpolation\Api\Parser\ParserPool;
use Fastwf\Interpolation\Lexer\Tokens\VariableToken;

/**
 * Interpolator that use lexer to parse and build the final value.
 */
class LexInterpolator implements InterpolatorInterface
{

    /**
     * The environment to use for interpolation.
     *
     * @var Environment
     */
    protected $environment;

    /**
     * The lexer ready to use for interpolation parsing.
     *
     * @var Lexer
     */
    protected $lexer;

    public function __construct($mark = "%", $start = "{", $end = "}", $environment = null)
    {
        $this->environment = $environment ?: new Environment();

        $this->lexer = new Lexer();

        // Add the left interpolation mark
        $sMark = RegexUtil::escape($mark);
        $sStart = RegexUtil::escape($start);
        $this->lexer->setToken(LD::T_LMARK, new Token("(?:^|[^\\\\])({$sMark}{$sStart})"));
        
        // Add the right interpolation mark
        $sEnd = RegexUtil::escape($end);
        $this->lexer->setToken(LD::T_RMARK, new Token($sEnd));

        // Add the token whitespace
        $this->lexer->setToken(LD::T_WHITESPACE, new Token("\\s*"));

        // Add langage token
        $this->lexer->setToken(LD::T_PIPE, new Token("\\|"));
        $this->lexer->setToken(LD::T_LPAREN, new Token("\\("));
        $this->lexer->setToken(LD::T_RPAREN, new Token("\\)"));
        $this->lexer->setToken(LD::T_COMMA, new Token(","));

        // Value tokens
        $this->lexer->setToken(LD::T_NULL, new NullToken());
        $this->lexer->setToken(LD::T_BOOLEAN, new BooleanToken());
        $this->lexer->setToken(LD::T_NUMBER, new NumberToken());
        $this->lexer->setToken(LD::T_STRING, new StringToken());
        $this->lexer->setToken(LD::T_VARIABLE, new VariableToken());
    }

    /**
     * The environment to use during template evaluation.
     *
     * @param Environment $environment the new environment.
     * @return void
     */
    public function setEnvironment($environment)
    {
        $this->environment = $environment;
    }

    /**
     * Get the environment to use during template evaluation.
     *
     * @return Environment the environment set.
     */
    public function getEnvironment()
    {
        return $this->environment;
    }

    public function interpolate($template, $parameters)
    {
        // Update lexer and environment
        $this->lexer->setSource($template);
        $this->environment->setVariables($parameters);

        $parser = new InterpolatorParser(new ParserPool($this->lexer));

        // Parse and evaluate the template
        return (string) $parser->parse()
            ->evaluate($this->environment);
    }

}
