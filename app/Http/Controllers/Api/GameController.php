<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Game;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class GameController extends Controller
{
    public function index(Request $request)
    {
        $page = $request->query('page') ?: 0;
        $size = $request->query('size') ?: 10;
        $sortBy = $request->query('sortBy') ?: 'title';
        $sortDir = $request->query('sortDir') ?: 'asc';

        $games = Game::query();

        if ($sortBy == 'title') {
            $games->orderBy('title', $sortDir);
        }
        if ($sortBy == 'uploaddate') {
            $games->orderBy('created_at', $sortDir);
        }

        $games = Game::with('latestVersion')->orderBy('latestVersion', $sortDir)->get();
        
        return $games;


        return [
            $page,
            $size,
            $sortBy,
            $sortDir,
        ];
    }
}
