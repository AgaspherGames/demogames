<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Admin;
use App\Models\Game;
use App\Models\GameScore;
use App\Models\GameVersion;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            UserSeeder::class,
            AdminSeeder::class,
            GameSeeder::class,
            GameVersionSeeder::class,
            GameScoreSeeder::class,
        ]);
    }
}

class UserSeeder extends Seeder
{
    public function run()
    {
        User::create([
            'username' => 'user1',
            'password' => bcrypt('password1'),
            'token' => 'token1',
            'last_login' => now(),
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        User::create([
            'username' => 'user2',
            'password' => bcrypt('password2'),
            'token' => 'token2',

            'last_login' => now(),
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        User::create([
            'username' => 'user3',
            'password' => bcrypt('password3'),
            'token' => 'token3',

            'last_login' => now(),
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
class AdminSeeder extends Seeder
{
    public function run()
    {
        Admin::create([
            'username' => 'admin1',
            'password' => bcrypt('password'),

            'last_login' => now(),
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
class GameSeeder extends Seeder
{
    public function run()
    {
        Game::create([
            'title' => 'Game1',
            'slug' => 'game1',
            'description' => 'description',
            'thumbnail' => 'thumbnail',
            'user_id' => 1,

            'created_at' => now(),
            'updated_at' => now(),
        ]);
        Game::create([
            'title' => 'Game2',
            'slug' => 'game2',
            'description' => 'description',
            'user_id' => 1,

            'created_at' => now(),
            'updated_at' => now(),
        ]);
        Game::create([
            'title' => 'Super Game',
            'slug' => 'super-game',
            'description' => 'this is best game',
            'user_id' => 2,

            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
class GameVersionSeeder extends Seeder
{
    public function run()
    {
        GameVersion::create([
            'game_id' => 1,
            'version' => now(),
            'path' => '/games/123',

            'created_at' => now(),
            'updated_at' => now(),
        ]);
        GameVersion::create([
            'game_id' => 1,
            'version' => now(),
            'path' => '/games/124',

            'created_at' => now(),
            'updated_at' => now(),
        ]);
        GameVersion::create([
            'game_id' => 2,
            'version' => now(),
            'path' => '/games/123',

            'created_at' => now(),
            'updated_at' => now(),
        ]);
        GameVersion::create([
            'game_id' => 3,
            'version' => now(),
            'path' => '/games/124',

            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
class GameScoreSeeder extends Seeder
{
    public function run()
    {
        GameScore::create([
            'user_id' => 1,
            'game_version_id' => 1,
            'score' => 4,

            'created_at' => now(),
            'updated_at' => now(),
        ]);
        GameScore::create([
            'user_id' => 2,
            'game_version_id' => 1,
            'score' => 6,

            'created_at' => now(),
            'updated_at' => now(),
        ]);
        GameScore::create([
            'user_id' => 2,
            'game_version_id' => 2,
            'score' => 1,

            'created_at' => now(),
            'updated_at' => now(),
        ]);
        GameScore::create([
            'user_id' => 2,
            'game_version_id' => 3,
            'score' => 1,

            'created_at' => now(),
            'updated_at' => now(),
        ]);
        GameScore::create([
            'user_id' => 1,
            'game_version_id' => 3,
            'score' => 5,

            'created_at' => now(),
            'updated_at' => now(),
        ]);
        GameScore::create([
            'user_id' => 3,
            'game_version_id' => 1,
            'score' => 100,

            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
