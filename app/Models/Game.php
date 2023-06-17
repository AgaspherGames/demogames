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

    public function latestVersion()
    {
        return $this->hasOne(GameVersion::class)->latest();
    }

    public function user(){
        return $this->belongsTo(User::class, 'user_id');
    }
    public function game_versions(){
        return $this->hasMany(GameVersion::class);
    }
}
