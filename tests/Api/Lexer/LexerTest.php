<?php

namespace Fastwf\Tests\Api\Lexer;

use Fastwf\Interpolation\Api\Exceptions\LexerException;
use Fastwf\Interpolation\Api\Lexer\Lexer;
use Fastwf\Interpolation\Lexer\Tokens\Token;
use PHPUnit\Framework\TestCase;

class LexerTest extends TestCase
{

    const T_VARNAME = 0;
    const T_LBRACK = 1;
    const T_RBRACK = 2;

    const TEMPLATE = "\nclass MyException extends Exception {}\n";


    /** @var Lexer */
    private $lexer;

    protected function setUp(): void
    {
        $this->lexer = new Lexer(self::TEMPLATE);

        $this->lexer->setToken(T_SPACESHIP, new Token('\\s*'));
        $this->lexer->setToken(T_CLASS, new Token('class'));
        $this->lexer->setToken(self::T_VARNAME, new Token('[a-zA-Z_][a-zA-Z0-9_]*'));
        $this->lexer->setToken(T_EXTENDS, new Token('extends'));
        $this->lexer->setToken(self::T_LBRACK, new Token('\\{'));
        $this->lexer->setToken(self::T_RBRACK, new Token('\\}'));
    }

    /**
     * @covers Fastwf\Interpolation\Api\Lexer\Lexer
     * @covers Fastwf\Interpolation\Api\Lexer\Token\AToken
     * @covers Fastwf\Interpolation\Lexer\Tokens\Token
     */
    public function testSkipSetSourceGetCurrent()
    {
        $this->assertEquals("\n", $this->lexer->skip(T_SPACESHIP)->getCurrent());

        $this->lexer->setSource(self::TEMPLATE);
        $this->assertNull($this->lexer->getCurrent());
    }

    /**
     * @covers Fastwf\Interpolation\Api\Lexer\Lexer
     * @covers Fastwf\Interpolation\Api\Lexer\Token\AToken
     * @covers Fastwf\Interpolation\Lexer\Tokens\Token
     */
    public function testSetTokenNull()
    {
        $this->expectException(LexerException::class);

        $this->lexer->setToken(self::T_VARNAME, null)
            ->getToken(self::T_VARNAME);
    }

    /**
     * @covers Fastwf\Interpolation\Api\Lexer\Lexer
     * @covers Fastwf\Interpolation\Api\Lexer\Token\AToken
     * @covers Fastwf\Interpolation\Lexer\Tokens\Token
     */
    public function testMoveToBefore()
    {
        $this->assertTrue($this->lexer->moveTo(T_EXTENDS));
        $this->assertEquals(
            "\nclass MyException ",
            $this->lexer->getCurrent()
        );
    }

    /**
     * @covers Fastwf\Interpolation\Api\Lexer\Lexer
     * @covers Fastwf\Interpolation\Api\Lexer\Token\AToken
     * @covers Fastwf\Interpolation\Lexer\Tokens\Token
     */
    public function testMoveToAfter()
    {
        $this->assertTrue($this->lexer->moveTo(T_EXTENDS, true));
        $this->assertEquals(
            "\nclass MyException ",
            $this->lexer->getCurrent()
        );
    }

    /**
     * @covers Fastwf\Interpolation\Api\Lexer\Lexer
     * @covers Fastwf\Interpolation\Api\Lexer\Token\AToken
     * @covers Fastwf\Interpolation\Lexer\Tokens\Token
     */
    public function testMoveToNotFoundAndIsEndOfFile()
    {
        $this->assertFalse($this->lexer->setToken(T_CASE, new Token('case'))->moveTo(T_CASE));
        $this->assertEquals(
            self::TEMPLATE,
            $this->lexer->getCurrent()
        );

        $this->assertTrue($this->lexer->isEndOfFile());
    }

    /**
     * @covers Fastwf\Interpolation\Api\Lexer\Lexer
     * @covers Fastwf\Interpolation\Api\Lexer\Token\AToken
     * @covers Fastwf\Interpolation\Lexer\Tokens\Token
     */
    public function testExpectToken()
    {
        $this->lexer->skip(T_SPACESHIP)->getCurrent();

        $this->assertNotNull($this->lexer->expectToken(T_CLASS));
    }

    /**
     * @covers Fastwf\Interpolation\Api\Lexer\Lexer
     * @covers Fastwf\Interpolation\Api\Lexer\Token\AToken
     * @covers Fastwf\Interpolation\Lexer\Tokens\Token
     */
    public function testExpectTokenFailed()
    {
        $this->expectException(LexerException::class);

        $this->lexer->skip(T_SPACESHIP)->getCurrent();

        $this->lexer->expectToken(T_EXTENDS);
    }

    /**
     * @covers Fastwf\Interpolation\Api\Lexer\Lexer
     * @covers Fastwf\Interpolation\Api\Lexer\Token\AToken
     * @covers Fastwf\Interpolation\Lexer\Tokens\Token
     */
    public function testLookAndIsEndOfFile()
    {
        $this->lexer->skip(T_SPACESHIP)->getCurrent();

        $this->assertTrue($this->lexer->look(T_CLASS));
        $this->assertFalse($this->lexer->look(self::T_LBRACK));

        $this->assertFalse($this->lexer->isEndOfFile());
    }

}
