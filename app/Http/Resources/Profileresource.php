<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class Profileresource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' =>$this->id,
            'name' => $this->name,
            'bio'=> $this->whenNotNull($this->bio),
            'linkedin'=>$this->whenNotNull($this->linkedin),
            'github'=>$this->whenNotNull($this->github),
            'photo'=>$this->whenNotNull($this->photo),
            'token'=> $this->whenNotNull($this->token),
            'user_id'=> $this->user_id
        ];
    }
}
