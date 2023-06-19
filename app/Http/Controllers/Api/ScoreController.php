<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Game;
use App\Models\GameScore;
use App\Models\GameVersion;
use App\Models\User;
use Illuminate\Http\Request;

class ScoreController extends Controller
{
    public function show(string $slug)
    {
        $game = Game::where('slug', $slug)->first();
        
        $scores = GameScore::select('*',)->whereHas('game_version', function($q) use($game){
            return $q->where('game_id',$game->id);
        })->orderBy('score', 'desc')->get()->unique('user_id');
        
        return $scores;
    }
    public function create(Request $request, string $slug)
    {
        $game = Game::where('slug', $slug)->first();
        $version = GameVersion::where('game_id', $game->id)->latest()->first();
        // $version = GameVersion::where('game_id', $game->id)->get()->last();
        $user = auth('sanctum')->user();

        $data = $request->validate([
            'score' => ['required'],
        ]);
        $data['user_id'] = $user->id;
        $data['game_version_id'] = $version->id;
        
        $score = GameScore::create($data);
        return response([
            "status" => "success",
        ], 201);
    }
}
