<?php

namespace Fastwf\Interpolation\Lexer\Tokens;

use Fastwf\Interpolation\Node\VariableNode;
use Fastwf\Interpolation\Api\Lexer\Token\AToken;

class VariableToken extends AToken
{

    public function __construct()
    {
        parent::__construct("[a-zA-Z_][a-zA-Z0-9_]*");
    }

    public function getNode($match)
    {
        return new VariableNode($match);
    }

}
