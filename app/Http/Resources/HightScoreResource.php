<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class HightScoreResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "score"=>$this->score,
            "timestamp"=>$this->created_at,
            "game"=>new GameUserResource($this->game_version->game),
        ];
    }
}
