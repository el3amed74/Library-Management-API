<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\BorrowingRequest;
use App\Http\Resources\BorrowingResource;
use App\Models\Book;
use App\Models\Borrowing;
use Illuminate\Http\Request;

class BorrowingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Borrowing::with('book', 'member');

        // search with status
        if ($request->has('status')) {
            $query->where('status', $request->status);
        }

        // search by member
        if ($request->has('member_id')) {
            $query->where('member_id', $request->member_id);
        }

        $borrowings = $query->latest()->paginate(10);

        return BorrowingResource::collection($borrowings);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(BorrowingRequest $request)
    {
        $book = Book::findOrFail($request->book_id);

        if (!$book->isAvailable()) {
            return response()->json([
                'msg' => 'This book is not available for borrowing'
            ]);
        }

        $borrowing = Borrowing::create($request->validated());

        $book->borrow();
        $borrowing->load(['book', 'member']);

        return new BorrowingResource($borrowing);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $borrowing = Borrowing::with(['book', 'member'])->find($id);

        if (! $borrowing) {
            return response()->json(['message' => 'Borrowing not found'], 404);
        }

        return new BorrowingResource($borrowing);
    }

    public function returnBook(Borrowing $borrowing)
    {
        if ($borrowing->status !== 'borrowed') {
            return response()->json([
                'msg' => 'this book has already returned '
            ]);
        }

        $borrowing->update([
            'returned_date' => now(),
            'status' => 'returned'
        ]);

        $borrowing->book->returnBook();
        $borrowing->load(['book', 'member']);

        return new BorrowingResource($borrowing);
    }

    public function overdue()
    {
        Borrowing::where('status', 'borrowed')
            ->where('due_date', '<', now())
            ->update(['status' => 'overdue']);

        $overDueBorrowings = Borrowing::with(['book', 'member'])
            ->where('status', 'overdue')
            ->where('due_date', '<', now())
            ->get();

        return BorrowingResource::collection($overDueBorrowings);
    }
}
