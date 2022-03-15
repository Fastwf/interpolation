<?php

namespace Fastwf\Interpolation\Api\Lexer\Token;

use Fastwf\Interpolation\Api\Lexer\Lexer;
use Fastwf\Interpolation\Api\Evaluation\NodeInterface;

/**
 * Base token definition.
 */
abstract class AToken
{

    /**
     * The pattern to use for matching value.
     *
     * @var string
     */
    protected $pattern;

    /**
     * Constructor.
     *
     * @param string $pattern The token pattern expected (if a group is set in pattern when {@see Lexer::moveTo} is called, the group is 
     *                        used instead of full match.)
     */
    public function __construct($pattern)
    {
        $this->pattern = $pattern;
    }

    /**
     * Get the token pattern.
     *
     * @return string
     */
    public function getPattern()
    {
        return $this->pattern;
    }

    /**
     * Get the node to use when the token match.
     *
     * @param string $match the sequence extracted from the regex.
     * @return NodeInterface|null the node to evaluate or null when no node are required for this token type.
     */
    public abstract function getNode($match);

}
