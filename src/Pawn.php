<?php declare(strict_types=1);

class Pawn extends Figure {
    public function __toString(): string {
        return $this->isBlack ? '♟' : '♙';
    }
}
