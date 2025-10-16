<?php

namespace App\Http\Resources;

use Illuminate\Database\Eloquent\Factories\Relationship;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AutherResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'name' => $this->name,
            'bio' => $this->bio,
            'nationality' => $this->nationality,
            // get related books to auther
            'books' => $this->when($this->relationLoaded('books'), $this->books->count())
        ];
    }
}
