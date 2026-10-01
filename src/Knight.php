<?php declare(strict_types=1);

class Knight extends Figure {
    public function __toString(): string {
        return $this->isBlack ? '♞' : '♘';
    }
}
