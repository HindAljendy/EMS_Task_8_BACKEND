<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;


class AuthController extends Controller
{

    /**
     * Create a new AuthController instance.
     *
     * @return void
     */


    /**
     * Register a User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function register(RegisterRequest $request) {

        $user = User::create([
            'name'          => $request->name,
            'email'         => $request->email,
            'password'      => Hash::make($request->password),
        ]);

        return response()->json([
            'message' => 'User successfully registered',
            'user' => $user
        ], 201);


    }
     /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(LoginRequest $request){

        $data_user = $request->only('email', 'password');

        if (!$token = auth()->attempt($data_user )) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
        return $this->createNewToken($token);
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout() {
        auth()->logout();
        return response()->json(['message' => 'User successfully signed out']);
    }
    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh() {
        $newToken = Auth::refresh();
        return $this->createNewToken($newToken);
    }
    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function userProfile() {
        return response()->json(auth()->user());
    }
    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function createNewToken($token){

        $expires = Auth::factory()->getTTL();

        return response()->json([
            'access_token' => $token,
            'token_type'   => 'bearer',
            'expires_in'   => $expires * 60,
            'user'         => auth()->user()
        ]);
    }
}
