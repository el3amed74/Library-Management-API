<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\MemberRequest;
use App\Http\Requests\UpdateMemberRequest;
use App\Http\Resources\MemberResource;
use App\Models\Member;
use Illuminate\Http\Request;
use PHPUnit\Metadata\Uses;

class MemberController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Member::with('activeBorrowings');

        // search by name email
        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%");
            });
        }

        // search by status
        if ($request->has('status')) {

            $query->where('status', $request->status);
        }

        $members = $query->paginate(10);

        return  MemberResource::collection($members);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(MemberRequest $request)
    {
        $member = Member::create($request->validated());
        return new MemberResource($member);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $member = Member::find($id);
        if ($member) {
            $member->load(['borrowings', 'activeBorrowings']);
            return new MemberResource($member);
        }

        return response()->json([
            'msg' => 'this member not found'
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateMemberRequest $request, Member $member)
    {
        $member->update($request->validated());
        return new MemberResource($member);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $member = Member::find($id);
        if ($member) {
            if ($member->activeBorrowings()->count()) {
                return response()->json([
                    'msg' => 'Cannot delete member with active borrowing'
                ]);
            }
            $member->delete();
            return response()->json([
                'msg' => 'this member deleted successfully'
            ]);
        }

        return response()->json([
            'msg' => "this member not found"
        ]);
    }
}
