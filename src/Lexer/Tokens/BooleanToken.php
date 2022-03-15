<?php

namespace Fastwf\Interpolation\Lexer\Tokens;

use Fastwf\Interpolation\Node\ValueNode;
use Fastwf\Interpolation\Api\Lexer\Token\AToken;

class BooleanToken extends AToken
{

    public function __construct()
    {
        parent::__construct("true|false");
    }

    public function getNode($match)
    {
        return new ValueNode($match === 'true');
    }

}
