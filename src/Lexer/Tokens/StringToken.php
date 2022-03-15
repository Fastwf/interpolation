<?php

namespace Fastwf\Interpolation\Lexer\Tokens;

use Fastwf\Interpolation\Node\ValueNode;
use Fastwf\Interpolation\Api\Lexer\Token\AToken;

class StringToken extends AToken
{

    private const ORD_BACKSLASH = 92;

    private const TABLE = [
        "n" => 10,
        "r" => 13,
        "t" => 9,
        "v" => 11,
        "e" => 27,
        "f" => 12,
        "\\" => self::ORD_BACKSLASH,
        "\"" => 34,
        "'" => 39,
    ];

    public function __construct()
    {
        parent::__construct("\"(?:[^\\\\\"]*\\\\\")*[^\"]*\"|'(?:[^\\\\']*\\\\')*[^']*'");
    }

    public function getNode($match)
    {
        return new ValueNode(self::parseString($match));
    }

    /**
     * Convert a string from it's representation.
     *
     * @param string $str the string to parse
     * @return string
     */
    public static function parseString($str)
    {
        $length = strlen($str) - 2;

        // Remove the first and last single or double quote
        $str = substr($str, 1, $length);
        $string = "";

        $offset = 0;
        while ($offset < $length)
        {
            // Catch the next party of the string to the first '\'
            //  [BEFORE]\[ESCAPED]
            $matches = [];
            if (
                preg_match(
                    "/([^\\\\]*)\\\\([nrtvef\\\\\"']|[0-7]{1,3}|x[0-9A-Fa-f]{1,2}|u{[0-9A-Fa-f]+})?/",
                    $str,
                    $matches,
                    PREG_OFFSET_CAPTURE,
                    $offset
                ) === 1
            )
            {
                // Add the first group directly to the output string
                $string .= $matches[1][0];
                
                $chars = isset($matches[2]) ? $matches[2][0] : "";
                if (ctype_digit($chars))
                {
                    // \[0-7]{1,3} -> is an octal to convert
                    $ord = octdec($chars);
                }
                else if (\array_key_exists($chars, self::TABLE))
                {
                    // It's a specific escaped character like \n, \r, \e ...
                    $ord = self::TABLE[$chars];
                }
                else
                {
                    // The sequence start with \x or \u or is ''
                    switch (substr($chars, 0, 1))
                    {
                        case 'x':
                            // Extract hexa part \x[0-9A-Fa-f]{1,2}
                            $ord = hexdec(substr($chars, 1));
                            break;
                        case 'u':
                            // Extract hexa part \u{[0-9A-Fa-f]+}
                            $ord = hexdec(substr($chars, 2, strlen($chars) - 3));
                            break;
                        default:
                            $ord = self::ORD_BACKSLASH;
                            break;
                    }
                }

                $string .= mb_chr($ord);

                $offset = $matches[0][1] + strlen($matches[0][0]);
            } else {
                $sub = substr($str, $offset);

                $string .= $sub;
                $offset += strlen($sub);
            }
        }

        return $string;
    }

}
