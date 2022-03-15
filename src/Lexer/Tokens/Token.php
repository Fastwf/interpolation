<?php

namespace Fastwf\Interpolation\Lexer\Tokens;

use Fastwf\Interpolation\Api\Lexer\Token\AToken;

/**
 * Generic token that allows to use a pattern and auto construct the node.
 */
class Token extends AToken
{

    protected $nodeClass;

    public function __construct($pattern, $nodeClass = null)
    {
        parent::__construct($pattern);

        $this->nodeClass = $nodeClass;
    }

    public function getNode($match)
    {
        return $this->nodeClass === null
            ? null
            : new $this->nodeClass($match);
    }

}
