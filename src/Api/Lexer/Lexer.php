<?php

namespace Fastwf\Interpolation\Api\Lexer;

use Fastwf\Interpolation\Lexer\Tokens\AToken;
use Fastwf\Interpolation\Api\Exceptions\LexerException;

/**
 * Lexer class based on regex match to travel the source and extract tokens.
 */
class Lexer {

    /**
     * The source to analyse.
     *
     * @var string
     */
    protected $source;

    /**
     * The source length.
     *
     * @var integer
     */
    protected $sourceLength;

    /**
     * The current offset.
     *
     * @var integer
     */
    protected $offset = 0;

    /**
     * The token known by lexer.
     *
     * @var array<int,AToken>
     */
    protected $tokens = [];

    /**
     * The last analysed token.
     *
     * @var string
     */
    protected $current;

    /**
     * Constructor.
     *
     * @param string|null $source The source content to analyse or null (set later using {@see Lexer::setSource})
     */
    public function __construct($source = null)
    {
        $this->setSource($source);
    }

    /**
     * Reset the source content of the lexer.
     *
     * @param string $source The new source content to analyse
     * @return void
     */
    public function setSource($source)
    {
        $this->source = $source;

        // Reset the internal state
        $this->sourceLength = strlen($this->source);
        $this->offset = 0;
        $this->current = null;
    }

    /**
     * Set a token for the given token id.
     *
     * @param int $id The token id.
     * @param AToken|null $token The token to use or null to remove the previous.
     * @return $this the lexer updated.
     */
    public function setToken($id, $token)
    {
        if ($token !== null)
        {
            $this->tokens[$id] = $token;
        }
        else if (isset($this->tokens[$id]))
        {
            unset($this->tokens[$id]);
        }

        return $this;
    }

    /**
     * Get the token associated to the given id.
     *
     * @param int $id The token id to search.
     * @return AToken The token associated.
     */
    public function getToken($id)
    {
        if (!array_key_exists($id, $this->tokens))
        {
            throw new LexerException("No token for type $id");
        }

        return $this->tokens[$id];
    }

    /**
     * Skip the given token if is found.
     *
     * @param integer $tokenId The id of the token to skip
     * @return $this
     */
    public function skip($tokenId)
    {
        $subSource = substr($this->source, $this->offset);

        $matches = [];
        if (preg_match("/^{$this->getToken($tokenId)->getPattern()}/", $subSource, $matches) === 1)
        {
            // The pattern is found, update the offset to move after
            $this->current = $matches[0];

            $this->offset += \strlen($this->current);
        }

        return $this;
    }

    /**
     * Allows to move to the next token.
     * 
     * If the token is not found, the lexer move to the end of the source.
     *
     * @param int $id the token id to find.
     * @param boolean $after true to move after the token, else move just before
     * @return $this
     */
    public function moveTo($id, $after = false)
    {
        $matches = [];
        if (preg_match("/{$this->getToken($id)->getPattern()}/", $this->source, $matches, PREG_OFFSET_CAPTURE, $this->offset) === 1)
        {
            // By default when it's required to move to token, the token is the full match.
            // If there is a more precise group set in token (a second group exists), we use this group as token
            // So we control the matches array to know if a sub group is captured
            $index = isset($matches[1]) ? 1 : 0;

            // Use the offset to update the content of 'current' property
            $lastOffset = $this->offset;
            $newOffset = $matches[$index][1];

            // Update the new offset
            $this->offset = $newOffset;
            if ($after)
            {
                // When $after is true, move after the token match
                $this->offset += strlen($matches[$index][0]);
            }

            // Set the current data from the previous offset to the start of the token match
            $this->current = substr($this->source, $lastOffset, $newOffset - $lastOffset);

            return true;
        }
        else
        {
            // The expected pattern is not found -> move to the end
            $lastOffset = $this->offset;
            $this->offset = strlen($this->source);

            // Set the current data from the offset to the end of the source
            $this->current = substr($this->source, $lastOffset);

            return false;
        }
    }

    /**
     * Expect one of the next token.
     *
     * @param array<integer> ...$ids the list of token ids.
     * @return AToken the token that match.
     * @throws LexerException when no token are found
     */
    public function expectToken(...$ids)
    {
        $subSource = substr($this->source, $this->offset);

        foreach ($ids as $id)
        {
            $token = $this->getToken($id);
            
            $matches = [];
            if (preg_match("/^(?:{$token->getPattern()})/", $subSource, $matches) === 1)
            {
                $this->current = $matches[0];
                $this->offset += strlen($this->current);

                return $token;
            }
        }

        // No token match in the source
        throw new LexerException("Unexpected token");
    }

    /**
     * Look for token
     *
     * @param array<integer> ...$ids The list of token to look.
     * @return boolean true when one of the token is match the source.
     */
    public function look(...$ids)
    {
        $subSource = substr($this->source, $this->offset);

        foreach ($ids as $id)
        {
            $token = $this->getToken($id);
            
            $matches = [];
            if (preg_match("/^(?:{$token->getPattern()})/", $subSource, $matches) === 1)
            {
                $this->current = $matches[0];

                return true;
            }
        }

        return false;
    }

    /**
     * True to indicate that the end of source is reached.
     *
     * @return boolean
     */
    public function isEndOfFile()
    {
        return $this->offset >= $this->sourceLength;
    }

    /**
     * Return the last data catched.
     *
     * @return string|null
     */
    public function getCurrent()
    {
        return $this->current;
    }

}
