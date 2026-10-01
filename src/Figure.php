<?php declare(strict_types=1);

class Figure {
    protected bool $isBlack;

    public function __construct(bool $isBlack) {
        $this->isBlack = $isBlack;
    }

    public function __toString(): string {
        throw new RuntimeException("Not implemented");
    }
}
