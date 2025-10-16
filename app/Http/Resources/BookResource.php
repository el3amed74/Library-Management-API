<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use App\Http\Resources\AutherResource;
use Illuminate\Http\Resources\Json\JsonResource;

class BookResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'title' => $this->title,
            'isbn' => $this->isbn,
            'description' => $this->description,
            'auther_id' => $this->auther_id,
            'genre' => $this->genre,
            'published_at' => $this->published_at,
            'total_copies' => $this->total_copies,
            'available_copies' => $this->available_copies,
            'price' => $this->price,
            'cover_image'=> $this->cover_image,
            'status' => $this->status,
            'is_available' => $this->isAvailable(),
            'auther' => new AutherResource($this->whenLoaded('auther'))
        ];
    }
}
