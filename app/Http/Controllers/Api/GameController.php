<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\GameResource;
use App\Http\Resources\GameSlugResource;
use App\Models\Game;
use App\Models\GameVersion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use ZipArchive;

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

        $games = $games->paginate($size);

        return [
            'page' => $games->currentPage(),
            'size' => $size,
            'totalElements' => $games->count(),
            'content' => GameResource::collection($games->items())
        ];


        return [
            $page,
            $size,
            $sortBy,
            $sortDir,
        ];
    }
    public function store(Request $request)
    {

        function makeSlug($title)
        {
            $slug = strtolower($title); // Convert title to lowercase
            $slug = preg_replace('/[^a-z0-9]+/', '-', $slug); // Replace non-alphanumeric characters with hyphens
            $slug = trim($slug, '-'); // Remove hyphens from the beginning and end
            $slug = preg_replace('/-+/', '-', $slug); // Replace consecutive hyphens with a single hyphen
            return $slug;
        }

        $data = $request->validate([
            "title" => ["required", "min:3", "max:60"],
            "description" => ["required", "min:0", "max:200"],
        ]);
        $slug = makeSlug($data["title"]);

        if (Game::where('slug', $slug)->first()) {
            return response([
                "status" => "invalid",
                "slug" => "Game title already exists"
            ], 400);
        }

        $data["slug"] = $slug;
        $data["user_id"] = auth('sanctum')->user()->id;
        $game = Game::create($data);
        return response([
            "status" => "success",
            "slug" => $slug
        ], 201);
    }
    public function show(string $slug)
    {
        $game = Game::where('slug', $slug)->first();
        return new GameSlugResource($game);
    }

    public function upload(Request $request, string $slug)
    {
        $game = Game::where('slug', $slug)->first();

        if (!$game) {
            return response([
                "status" => "invalid",
                "message" => "No such game"
            ], 400);
        }

        if (auth('sanctum')->user()->id != $game->user->id) {
            return response([
                "status" => "invalid",
                "message" => "User is not author of the game"
            ], 400);
        }

        $version = GameVersion::create([
            "game_id" => $game->id,
            "version" => now(),
            "path" => "/$game->slug/temp/index.html"
        ]);

        $dir_path = $game->slug . '/';
        $file = request()->file('zipfile');
        $zip = new ZipArchive();
        $file_new_path = $file->storeAs($dir_path . "v" . $version->id, 'zipname', 'public');
        $zipFile = $zip->open(Storage::disk('public')->path($file_new_path));
        if ($zipFile === TRUE) {
            $zip->extractTo(Storage::disk('public')->path($dir_path . "v" . $version->id));
            $zip->close();
        } else {
            return response([
                "status" => "invalid",
                "message" => "ZIP file extraction fails"
            ], 400);
        }
        if (file_exists(Storage::disk('public')->path($dir_path . "v$version->id/thumbnail.png"))) {
            $game->thumbnail = "/$game->slug/v$version->id/thumbnail.png";
            $game->save();
        }
        $version->path = "/$game->slug/v$version->id/index.html";
        $version->save();
        return url('storage' . $version->path);
    }

    public function update(Request $request, string $slug)
    {
        $game = Game::where('slug', $slug)->first();

        if (auth('sanctum')->user()->id != $game->user->id) {
            return response([
                "status" => "forbidden",
                "message" => "You are not the game author"
            ], 400);
        }

        $data = $request->validate([
            "title" => "string",
            "description" => "string",
        ]);
        if (isset($data['title'])) {
            $game->title = $data['title'];
        }
        if (isset($data['description'])) {
            $game->description = $data['description'];
        }
        $game->save();
        return response([
            "status" => "success"
        ]);
    }
    public function delete(string $slug)
    {
        $game = Game::where('slug', $slug)->first();

        if (auth('sanctum')->user()->id != $game->user->id) {
            return response([
                "status" => "forbidden",
                "message" => "You are not the game author"
            ], 400);
        }

        $game->delete();
        return response([],204);
    }
}
