<?php declare(strict_types = 1);
namespace TheSeer\Tokenizer;

class TokenCollection implements \ArrayAccess, \Iterator, \Countable {

    /**
     * @var Token[]
     */
    private $tokens = [];

    /**
     * @var int
     */
    private $pos;

    /**
     * @param Token $token
     */
    public function addToken(Token $token) {
        $this->tokens[] = $token;
    }

    /**
     * @return Token
     */
    public function current(): Token {
        return current($this->tokens);
    }

    /**
     * @return int
     */
    public function key(): int {
        return key($this->tokens);
    }

    /**
     * @return void
     */
    public function next() {
        next($this->tokens);
        $this->pos++;
    }

    /**
     * @return bool
     */
    public function valid(): bool {
        return $this->count() > $this->pos;
    }

    /**
     * @return void
     */
    public function rewind() {
        reset($this->tokens);
        $this->pos = 0;
    }

    /**
     * @return int
     */
    public function count(): int {
        return count($this->tokens);
    }

    /**
     * @param mixed $offset
     *
     * @return bool
     */
    public function offsetExists($offset): bool {
        return isset($this->tokens[$offset]);
    }

    /**
     * @param mixed $offset
     *
     * @return Token
     * @throws TokenCollectionException
     */
    public function offsetGet($offset): Token {
        if (!$this->offsetExists($offset)) {
            throw new TokenCollectionException(
                sprintf('No Token at offest %s', $offset)
            );
        }

        return $this->tokens[$offset];
    }

    /**
     * @param mixed $offset
     * @param Token $value
     *
     * @throws TokenCollectionException
     */
    public function offsetSet($offset, $value) {
        if (!is_int($offset)) {
            $type = gettype($offset);
            throw new TokenCollectionException(
                sprintf(
                    'Offset must be of type integer, %s given',
                    $type === 'object' ? get_class($value) : $type
                )
            );
        }
        if (!$value instanceof Token) {
            $type = gettype($value);
            throw new TokenCollectionException(
                sprintf(
                    'Value must be of type %s, %s given',
                    Token::class,
                    $type === 'object' ? get_class($value) : $type
                )
            );
        }
        $this->tokens[$offset] = $value;
    }

    /**
     * @param mixed $offset
     */
    public function offsetUnset($offset) {
        unset($this->tokens[$offset]);
    }

}
