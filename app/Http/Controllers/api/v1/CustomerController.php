<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use App\Http\Resources\api\v1\CustomerCollection;
use App\Http\Resources\api\v1\CustomerResource;
use App\Models\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $customers = User::orderBy('id', 'asc')
            ->where('status', 'active')
            ->where('user_type', 2)
            ->paginate(5);

        return new CustomerCollection($customers);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $newCustomer = User::create(
            [
                'name' => $request->name,
                'email' => $request->email,
                'password' => bcrypt($request->password),
                'user_type' => 2,
                'status' => 'active',
            ]
        );

        return response()->json([
            'data' => new CustomerResource($newCustomer),
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try {
            $customer = User::findOrFail($id);

            return response()->json([
                'data' => new CustomerResource($customer),
            ], 200);
        } catch (ModelNotFoundException $exception) {
            return response()->json([
                'message' => 'Customer not found'
            ], 404);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $customer = User::findOrFail($id)
                ->where('user_type', 2)
                ->where('status', 'active')
                ->first();
            $customer->status = 'inactive';
            $customer->save();

            return response()->json([
                'data' => 'Customer removed successfully',
            ], 204);
        } catch (ModelNotFoundException $exception) {
            return response()->json([
                'message' => 'Customer not found'
            ], 404);
        }
    }
}
