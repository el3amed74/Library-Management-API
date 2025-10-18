<?php

namespace App\Http\Controllers\Api;

use App\Models\Book;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\BookRequest;
use App\Http\Requests\UpdateBookRequest;
use App\Http\Resources\BookResource;

class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Book::with('auther');
        
        // search functionality by title,isbn and auther name 

        if($request->has('search')){
            $search = $request->search;

            $query->where(function($q) use ($search){
                $q->where('title','like',"%{$search}%")
                ->orWhere('isbn','like',"%{$search}%")
                ->orWhereHas('auther',function($autherQuery) use ($search){
                    $autherQuery->where('name','like',"%{$search}%");
                });
            });
        }

        if($request->has('genre')){
            $search = $request->genre;

            $query->where('genre',$request->genre);
        }

        $books=$query->paginate(10);
        return BookResource::collection($books);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(BookRequest $request)
    {
        $book = Book::create($request->validated());
        $book->load('auther');
        return new BookResource($book);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $book= Book::find($id);
        if($book){
            $book->load('auther');
            return new BookResource($book);
        }

        return response()->json([
            'msg'=>"this element not found"
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateBookRequest $request, Book $book)
    {
        // $book= Book::find($id);
        $book->update($request->validated());
        $book->load('auther');
        return new BookResource($book);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $book= Book::find($id);
        

        if ($book) {
            $book->delete();
            return response()->json([
                'msg'=>'Book Deleted successfuly'
            ]);
        }
        return response()->json([
            'msg' => "this data not found"
        ]);
    }
}
