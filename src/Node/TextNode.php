<?php

namespace Fastwf\Interpolation\Node;

use Fastwf\Interpolation\Api\Evaluation\NodeInterface;

class TextNode implements NodeInterface
{

    private $text;

    public function __construct($text)
    {
        $this->text = $text;
    }

    public function evaluate($environment)
    {
        return $this->text;
    }

}
