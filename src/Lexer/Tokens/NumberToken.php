<?php

namespace Fastwf\Interpolation\Lexer\Tokens;

use Fastwf\Interpolation\Node\ValueNode;
use Fastwf\Interpolation\Api\Lexer\Token\AToken;

class NumberToken extends AToken
{

    public function __construct()
    {
        parent::__construct("\\d+(?:\\.\\d*)?|\\d*\\.\\d+");
    }

    public function getNode($match)
    {
        return new ValueNode(strpos($match, '.') !== false ? (double) $match : (int) $match);
    }

}
