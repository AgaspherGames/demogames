<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class GameVersion extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'game_id',
        'version',
        'path',
    ];

    protected static function boot()
    {
        parent::boot();

        static::deleted(function ($parent) {
            $parent->game_scores()->delete();
        });
    }

    public function game(){
        return $this->belongsTo(Game::class, 'game_id');
    }

    public function game_scores(){
        return $this->hasMany(GameScore::class);
    }
}
