<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Game;
use Illuminate\Foundation\Testing\RefreshDatabase;

class GameControllerTest extends TestCase
{
    use RefreshDatabase;

    // Test case for checking if 'X' wins
    public function test_check_win_x()
    {
        $box = ['x', 'x', 'x', '', '', '', '', '', ''];
        $this->assertTrue($this->checkplayerWin($box, 'x'));
    }

    // Test case for checking if 'O' wins
    public function test_check_win_o()
    {
        $box = ['', '', '', 'o', 'o', 'o', '', '', ''];
        $this->assertTrue($this->checkplayerWin($box, 'o'));
    }



    // Test case for checking ongoing game (no winner yet)
    public function test_check_ongoing_game()
    {
        $box = ['x', 'o', '', '', '', '', '', '', ''];
        $this->assertFalse($this->checkplayerWin($box, 'x'));
        $this->assertFalse($this->checkplayerWin($box, 'o'));
    }


    // Test for a full board and draw condition
    public function test_draw_condition()
    {
        $box = ['x', 'o', 'x', 'o', 'x', 'o', 'o', 'x', 'o']; // Full board

        $this->assertFalse($this->checkplayerWin($box, 'x'));
        $this->assertFalse($this->checkplayerWin($box, 'o'));
    }

    // Test for empty board to ensure no winner yet
    public function test_empty_board()
    {
        $box = ['', '', '', '', '', '', '', '', ''];
        $this->assertFalse($this->checkplayerWin($box, 'x'));
        $this->assertFalse($this->checkplayerWin($box, 'o'));
    }

    // Test if a game is correctly initialized and started
    public function test_game_initialization()
    {
        $response = $this->get('/');
        $response->assertStatus(200);
        $response->assertViewHas('box', array_fill(0, 9, ''));
    }

    // checking win condition
    private function checkplayerWin($box, $player)
    {
        $winning_combinations = [
            [0, 1, 2], [3, 4, 5], [6, 7, 8],  // horizontal lines
            [0, 3, 6], [1, 4, 7], [2, 5, 8],  // vertical lines
            [0, 4, 8], [2, 4, 6]              // diagonal lines
        ];

        foreach ($winning_combinations as $combination) {
            if ($box[$combination[0]] === $player &&
                $box[$combination[1]] === $player &&
                $box[$combination[2]] === $player) {
                return true;
            }
        }

        return false;
    }
}
