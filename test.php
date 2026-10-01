<?php declare(strict_types=1);

use PHPUnit\Framework\Attributes\Group;
use PHPUnit\Framework\TestCase;

require_once __DIR__ . '/vendor/autoload.php';

class Test extends TestCase {
    #[Group('rotation')]
    #[Group('pawn')]
    public function testNoMoves(): void {
        $this->runFile('tests/001-no-moves.test');
    }

    #[Group('pawn')]
    public function testSimpleError(): void {
        $this->runFile('tests/011-simple-error.test');
    }

    #[Group('rotation')]
    #[Group('pawn')]
    public function testSimple(): void {
        $this->runFile('tests/012-simple-move.test');
    }

    #[Group('rotation')]
    public function testColorRotationError(): void {
        $this->runFile('tests/013-color-rotation-error.test');
    }

    #[Group('rotation')]
    #[Group('pawn')]
    public function testColorRotationCorrect(): void {
        $this->runFile('tests/014-color-rotation-correct.test');
    }

    #[Group('rotation')]
    #[Group('pawn')]
    public function testPawnMovesOneSquareVertically(): void {
        $this->runFile('tests/021-pawn-moves-one-square-vertically.test');
    }

    #[Group('rotation')]
    #[Group('pawn')]
    public function testPawnCanMoveTwoSquaresOnFirstMove(): void {
        $this->runFile('tests/022-pawn-can-move-two-squares-on-first-move.test');
    }

    #[Group('pawn')]
    public function testPawnCanNotMoveDiagonally(): void {
        $this->runFile('tests/023-pawn-can-not-move-diagonally.test');
    }

    #[Group('rotation')]
    #[Group('pawn')]
    public function testPawnCapturesDiagonally(): void {
        $this->runFile('tests/024-pawn-captures-diagonally.test');
    }

    #[Group('pawn')]
    public function testPawnCanNotCaptureVertically(): void {
        $this->runFile('tests/025-pawn-can-not-capture-vertically.test');
    }

    #[Group('pawn')]
    public function testPawnCanNotMoveFartherOneSquare(): void {
        $this->runFile('tests/026-pawn-can-not-move-farther-one-square.test');
    }

    #[Group('pawn')]
    public function testPawnCanNotMoveAcrossFigure(): void {
        $this->runFile('tests/027-pawn-can-not-move-across-figure.test');
    }


    /**
     * Test file structure
     *
     * line 1: moves as arguments to chess.php
     * line 2: 'correct' if all moves are correct, 'error' if there are incorrect moves
     * Other lines: output of chess.php (final chess board) if all moves are correct
     *
     * @param string $file
     */
    private function runFile(string $file): void {
        $lines     = file($file);
        $moves     = trim($lines[0]);
        $movesDesc = $moves ?: '(no moves)';
        unset($lines[0]);

        $isCorrect = trim($lines[1]) !== 'error';
        unset($lines[1]);

        $redColor = '';
        $noColor  = '';
        if (function_exists('posix_isatty') && posix_isatty(STDOUT)) {
            $redColor = "\033[31m";
            $noColor  = "\033[m";
        }

        $out = [];
        exec('php chess.php ' . $moves, $out, $err);
        if ($isCorrect) {
            static::assertEquals(0, $err, $redColor . "Moves are correct, but chess.php thinks there is an error:\n" . $movesDesc . $noColor . "\n");
            // does not work properly on windows
            // $this->assertEquals(join("", $lines), join("\n", $out) . "\n");
        } else {
            static::assertNotEquals(0, $err, $redColor . "Moves are invalid, but chess.php does not detect that:\n" . $movesDesc . $noColor . "\n");
        }
    }
}
