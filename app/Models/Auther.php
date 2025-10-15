<?php

namespace App\Models;

use App\Models\Book;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Auther extends Model
{
    /** @use HasFactory<\Database\Factories\AutherFactory> */
    use HasFactory;

    protected $fillable = [
        'name',
        'bio',
        'nationality',

    ];

    public function books()
    {
        return $this->hasMany(Book::class);
    }
}
