<?php declare(strict_types = 1);
namespace foo;

class bar {
    const x = 'abc';

    /** @var int */
    private $y = 1;

    public function __construct() {
        // do something
    }

    public function getY(): int {
        return $this->y;
    }

    public function getSomeX(): string {
        return self::x;
    }

    public function some(bar $b): string {
        return $b->getSomeX() . '-def';
    }
}
