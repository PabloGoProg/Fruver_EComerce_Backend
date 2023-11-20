<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\UserType;
use App\Http\Resources\api\v1\UserTypeResource;
use App\Http\Requests\api\v1\UserTypeStoreRequest;
use App\Http\Requests\api\v1\UserTypeUpdateRequest;

class UserTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $userTypes = UserType::orderBy('id', 'asc')->get();

        return response()->json([
            'data' => UserTypeResource::collection($userTypes),
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(UserTypeStoreRequest $request)
    {
        $userType = UserType::create($request->all());

        return response()->json(
            [
                'data' => new UserTypeResource($userType)
            ],
            201
        );
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $userType = UserType::findOrFail($id);

        return response()->json(
            [
                'data' => new UserTypeResource($userType)
            ],
            200
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UserTypeUpdateRequest $request, string $id)
    {
        $userType = UserType::findOrFail($id);
        $userType->update($request->all());

        return response()->json(
            [
                'data' => new UserTypeResource($userType)
            ],
            200
        );
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $userType = UserType::findOrFail($id);
        $userType->delete();

        return response()->json(null, 204);
    }
}
