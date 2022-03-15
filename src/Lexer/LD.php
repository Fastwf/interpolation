<?php

namespace Fastwf\Interpolation\Lexer;

/**
 * The lexer definition class.
 * 
 * This class must be used for token type declaration.
 */
abstract class LD
{

    /** Token type null */
    public const T_NULL = 0;
    /** Token type for boolean */
    public const T_BOOLEAN = 1;
    /** Token type for integer and double */
    public const T_NUMBER = 2;
    /** Token type for string sequences */
    public const T_STRING = 3;

    /** Token type for white spaces */
    public const T_WHITESPACE = 5;
    /** Token for end of file */
    public const T_EOF = 6;

    /** Token for variable name */
    public const T_VARIABLE = 10;

    /** Token for interpolation start mark */
    public const T_LMARK = 20;
    /** Token for interpolation end mark */
    public const T_RMARK = 21;
    /** Token for pipe mark */
    public const T_PIPE = 22;
    /** Token for left parenthese */
    public const T_LPAREN = 23;
    /** Token for right parenthese */
    public const T_RPAREN = 24;
    /** Token for comma */
    public const T_COMMA = 25;

}
