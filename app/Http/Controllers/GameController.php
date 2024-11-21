<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Game;

class GameController extends Controller
{
    public function index(Request $request)
    {
        $box = array_fill(0, 9, '');
        $winner = 'n'; // Default winner is 'n' (none)
        $outcome = '';
        $game = null;

        if ($request->isMethod('post')) {
            // Get the current state of the board from the form
            $box = [
                $request->input('box0'),
                $request->input('box1'),
                $request->input('box2'),
                $request->input('box3'),
                $request->input('box4'),
                $request->input('box5'),
                $request->input('box6'),
                $request->input('box7'),
                $request->input('box8'),
            ];
            // Check if player X wins
            if ($this->checkplayerWin($box, 'x')) {
                $winner = 'x is winner';
                $outcome = 'X Wins!';
            }
            // Check if player O wins
            elseif ($this->checkplayerWin($box, 'o')) {
                $winner = 'o is winner';
                $outcome = 'O Wins!';
            }
            // If no winner, check for draw Match
            else {
                $blank = in_array('', $box);  // Check if there are any empty spaces
                if ($blank) {
                    // Make a move for O
                    $emptyIndexes = array_keys($box, '');
                    if (!empty($emptyIndexes)) {
                        $i = $emptyIndexes[array_rand($emptyIndexes)];
                        $box[$i] = 'o';
                        // Check if 'O' wins after making the move
                        if ($this->checkplayerWin($box, 'o')) {
                            $winner = 'o is winner';
                            $outcome = 'O Wins!';
                        }
                    }
                } else {
                    // If no empty spots, it's a draw
                    $winner = 'Game draw';
                    $outcome = 'Game draw!';
                }
            }

            // Save the game results to the database
            $game = Game::create([
                'moves' => json_encode($box),
                'outcome' => $winner,
            ]);
        }

        return view('game', compact('box', 'outcome', 'game'));
    }

    // check if a player has won
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
