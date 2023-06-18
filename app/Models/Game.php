<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Game extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'title',
        'slug',
        'description',
        'thumbnail',
        'user_id',
    ];

    protected static function boot()
    {
        parent::boot();

        static::deleted(function ($parent) {
            // $versions = $parent->game_versions();
            $versions = $parent->game_versions;
            foreach($versions as $version){
                $version->delete();
            }
        });
    }


    public function latestVersion()
    {
        return $this->hasOne(GameVersion::class)->latestOfMany();
    }


    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    public function game_versions()
    {
        return $this->hasMany(GameVersion::class);
    }
    public function gameScores()
    {
        return 4;
        return $this->game_versions->sum(function ($query) {
            return $query->game_scores->count();
        });
    }
}
