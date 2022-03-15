<?php

namespace Fastwf\Interpolation\Lexer\Tokens;

use Fastwf\Interpolation\Node\ValueNode;
use Fastwf\Interpolation\Api\Lexer\Token\AToken;

class NullToken extends AToken
{

    public function __construct()
    {
        parent::__construct("null");
    }

    public function getNode($match)
    {
        return new ValueNode(null);
    }

}
