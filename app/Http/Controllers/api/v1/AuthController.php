<?php

namespace App\Http\Controllers\api\v1;

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Http\Resources\api\v1\UserResource;
use App\Http\Requests\api\v1\UserStoreRequest;
use Illuminate\Support\Facades\Cookie;
use App\Models\User;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login', 'register']]);
    }

    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request)
    {
        try {
            $request->validate([
                'email' => 'required|string|email|max:255|exists:users',
                'password' => 'required|string|min:7',
            ]);
        } catch (ValidationException $e) {
            return response()->json([
                'message' => $e->getMessage()
            ], $e->status);
        }

        if (!Auth::attempt($request->only('email', 'password'))) {
            return response()->json([
                'error' => 'Invalid login credentials'
            ], 401);
        }

        try {
            return $this->respondWithToken(Auth::refresh());
        } catch (\Tymon\JWTAuth\Exceptions\TokenInvalidException $e) {
            return response()->json(['error' => 'Token is invalid'], 401);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error refreshing token'], 500);
        }
    }

    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function me()
    {
        return response()->json(new UserResource(Auth::user()), 200);
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        Auth::logout();
        Cookie::forget('accessToken');

        return response()->json([
            'message' => 'Successfully logged out'
        ], 201);
    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh(string $email)
    {
        /**
         * Eliminación de tokens previos del usuario de tipo bearer
         */
        $tokenType = 'Bearer';
        $user = User::where('email', $email)->firstOrFail();

        $user->tokens()->where('name', $tokenType)->delete();

        /**
         * Remove the cookies with access tokens from the user
         */
        Cookie::forget('accessToken');

        /**
         * Creation of a new token to the user
         */
        return $this->respondWithToken(Auth::refresh());
    }

    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token)
    {
        /**
         * Returns the user token via cookie
         */
        return response([
            'message' => 'Sucess login process',
        ], 201)->withCookie(
            'accessToken',
            $token,
            60 * 24 * 7,
            null,
            null,
            false,
            true
        );
    }

    public function register(UserStoreRequest $request)
    {
        $user = User::create(
            [
                'name' => $request->name,
                'email' => $request->email,
                'password' => bcrypt($request->password),
                'userType' => 2,
            ]
        );

        return response()->json(
            [
                'data' => new UserResource($user)
            ],
            201
        );
    }
}
