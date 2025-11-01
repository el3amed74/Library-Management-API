<?php

use App\Models\Book;
use App\Models\Auther;
use App\Models\Member;
use App\Models\Borrowing;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\BookController;
use App\Http\Controllers\Api\AutherController;
use App\Http\Controllers\Api\MemberController;
use App\Http\Controllers\Api\BorrowingController;


//register
Route::post('register', [AuthController::class, 'register']);
// login
Route::post('login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    // get authenticated user 
    Route::get('user', [AuthController::class, 'user']);
    // logout
    Route::post('logout', [AuthController::class, 'logout']);


    Route::apiResource('authers', AutherController::class);
    Route::apiResource('books', BookController::class);
    Route::apiResource('members', MemberController::class);
    Route::apiResource('borrowings', BorrowingController::class)->only('index', 'store', 'show');

    Route::get('borrowings/overdue/list', [BorrowingController::class, 'overdue']);
    Route::post('borrowings/{borrowing}/return', [BorrowingController::class, 'returnBook']);

    // statistics
    Route::get('statistics', function () {
        return response()->json([
            'total_books' => Book::count(),
            'total_authors' => Auther::count(),
            'total_members' => Member::count(),
            'book_borrowed' => Borrowing::where('status', 'borrowed')->count(),
            'overdue_borrowings' => Borrowing::where('status', 'overdue')->count()
        ]);
    });
});
