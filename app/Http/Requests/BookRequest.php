<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BookRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title' => 'required|string|max:255',
            'isbn' => 'required|string|max:255|unique:books,isbn',
            'description' => 'nullable|string',
            'auther_id' => 'required|exists:authers,id',
            'genre' => 'nullable|string',
            'published_at' => 'nullable|date',
            'total_copies' => 'required|integer|min:1',
            'price' => 'nullable|numiric|min:0',
            'cover_image'=> 'nullable|string',
        ];
    }
}
