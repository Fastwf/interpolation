<?php

namespace Fastwf\Interpolation\Api\Parser;

use Fastwf\Interpolation\Node\NodeInterface;
use Fastwf\Interpolation\Lexer\Lexer;
use Fastwf\Interpolation\Api\Parser\ParserPool;

/**
 * The parser methods required to parse a source.
 */
abstract class AParser
{

    /**
     * The parent pool of parsers.
     *
     * @var ParserPool
     */
    protected $pool;

    /**
     * The lexer ready to iterate.
     *
     * @var Lexer
     */
    protected $lexer;

    /**
     * Constructor.
     *
     * @param ParserPool $pool The parent pool.
     */
    public function __construct($pool)
    {
        $this->pool = $pool;
        $this->lexer = $pool->getLexer();
    }

    /**
     * Parse the corpux using the lexer holding the document.
     *
     * @return NodeInterface the abstract syntax tree node for evaluation.
     */
    public abstract function parse();

}
