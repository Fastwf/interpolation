<?php

namespace Fastwf\Interpolation\Utils;

/**
 * Util that define utilitary function for regex purpose.
 */
class RegexUtil
{

    const SPECIALS = ['.', '^', '$', '*', '+', '-', '?', '(', ')', '[', ']', '{', '}', '\\', '|'];

    /**
     * Escape the regular expression special chars.
     *
     * ```php
     * RegexUtil::escape('a'); // return 'a'
     * RegexUtil::escape('.'); // return '\.'
     * ```
     * 
     * @param string $char the char to inject in regex.
     * @return string the escaped char (if required).
     */
    public static function escape($char)
    {
        return \in_array($char, self::SPECIALS) ? "\\${char}" : $char;
    }

}
