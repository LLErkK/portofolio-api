<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class EducationResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "id"=> $this->id,
            "school_name"=> $this->school_name,
            "start_year"=> $this->start_year,
            "end_year"=> $this->end_year,
            "address"=> $this->address,
            "user_id"=>$this->user_id
        ];
    }
}
