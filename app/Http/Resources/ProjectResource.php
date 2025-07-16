<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class ProjectResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->description,
            'link' => $this->link,
            'tech_stack' => $this->tech_stack,
            'images' => collect($this->images)->map(function ($imagePath) {
                return Storage::url($imagePath); // ← Ubah path jadi URL publik
            }),
            'user_id'=>$this->user_id
        ];
    }
}
