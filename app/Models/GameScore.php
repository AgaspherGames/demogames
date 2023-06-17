<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class GameScore extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id',
        'game_version_id',
        'score',
    ];

    public function user(){
        return $this->belongsTo(User::class,'user_id');
    }
    public function game_version(){
        return $this->belongsTo(GameVersion::class,'game_version_id');
    }
}
