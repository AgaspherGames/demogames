<?php

namespace App\Http\Controllers;

use App\Models\Game;
use Illuminate\Http\Request;

class GameController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $queryStr = $request->query('search');

        $games = Game::withTrashed()
            ->with('user')
            ->where('title', 'like', '%' . $queryStr . '%')
            ->orWhere('description', 'like', '%' . $queryStr . '%')
            ->orWhereHas('user', function ($query) use ($queryStr) {
                $query->where('username', 'like', '%' . $queryStr . '%');
            })
            ->get();

        return view('gameList', compact('games'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, string $slug)
    {
        $game = Game::withTrashed()->where('slug', $slug)->first();
        return view('gamePage', compact('game'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, string $slug)
    {
        $game = Game::withTrashed()
            ->where('slug', $slug)->first();
        $game->delete();
        return view('gamePage', compact('game'));
    }
}
