<?php

namespace App\Models;

use App\Models\Auther;
use App\Models\Borrowing;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Book extends Model
{
    /** @use HasFactory<\Database\Factories\BookFactory> */
    use HasFactory;

    protected $fillable = [
        'title',
        'isbn',
        'description',
        'auther_id',
        'genre',
        'published_at',
        'total_copies',
        'available_copies',
        'price',
        'cover_image',
        'status',
    ];

    public function auther()
    {
        return $this->belongsTo(Auther::class);
    }

    public function borrowings()
    {
        return $this->hasMany(Borrowing::class);
    }

    public function isAvailable()
    {
        return $this->available_copies > 0;
    }

    public function borrow(){
        if($this->available_copies > 0){
            return $this->decrement('available_copies');
        }
    }

    public function returnBook(){
        if($this->available_copies < $this->total_copies){
            return $this->increment('available_copies');
        }
    }
}
