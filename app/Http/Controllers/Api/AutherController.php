<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\AutherRequest;
use App\Http\Resources\AutherResource;
use App\Models\Auther;
use Illuminate\Http\Request;

class AutherController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $authers = Auther::with('books')->paginate(10);

        return AutherResource::collection($authers);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(AutherRequest $request)
    {
        $auther = Auther::create($request->validated());

        return new AutherResource($auther);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $auther = Auther::with('books')->find($id);
        if ($auther) {
            return new AutherResource($auther);
        }
        return response()->json([
            'msg' => "this data not found"
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(AutherRequest $request, Auther $auther)
    {
        $auther->update($request->validated());

        return new AutherResource($auther);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
        $auther = Auther::find($id);
        if ($auther) {
            $auther->delete();
            return response()->json([
                'msg'=>'Author Deleted successfuly'
            ]);
        }
        return response()->json([
            'msg' => "this data not found"
        ]);

    }
}
