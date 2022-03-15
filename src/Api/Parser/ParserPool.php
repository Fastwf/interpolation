<?php

namespace Fastwf\Interpolation\Api\Parser;

use Fastwf\Interpolation\Parser\AParser;
use Fastwf\Interpolation\Api\Lexer\Lexer;

/**
 * Parser factory that allows to reduce memory usage to parse source using lexer.
 */
class ParserPool
{

    /**
     * The lexer it is attached to.
     *
     * @var Lexer
     */
    private $lexer;

    /**
     * The pool of parsers.
     *
     * @var Array<string,AParser>
     */
    private $pool = [];

    public function __construct($lexer)
    {
        $this->lexer = $lexer;
    }

    /**
     * Get the lexer.
     *
     * @return Lexer The lexer of the pool.
     */
    public function getLexer()
    {
        return $this->lexer;
    }

    /**
     * Return a singleton instance of the parser.
     *
     * @template T
     * @param class-string<T> $className the parser class (must extends {@see AParser})
     * @return T the instance of the parser
     */
    public function get($className)
    {
        if (!\array_key_exists($className, $this->pool))
        {
            $this->pool[$className] = new $className($this);
        }

        return $this->pool[$className];
    }

}
