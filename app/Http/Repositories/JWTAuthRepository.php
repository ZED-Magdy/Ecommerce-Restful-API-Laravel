<?php

namespace App\Http\Repositories;

use App\Http\Repositories\Interfaces\ApiAuthInterface;
use App\Http\Resources\UserResource;
use App\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

class JWTAuthRepository implements ApiAuthInterface{

    public function register(array $credentials): JsonResponse
    {
        DB::transaction(function () use($credentials) {
            $user = User::create([
                "name"     => $credentials['name'],
                "email"    => $credentials['email'],
                "password" => bcrypt($credentials['password']),
                "address"  => $credentials['address'],
                "number"   => $credentials['number'],
                "gender"   => $credentials['gender']
            ]);
            $user->addAvatar($credentials['image']);
            //TODO: Add Role
        });
        return response()->json(["message" => "successfully Registered"]);
    }
    /**
     *
     * @param array $credentials
     * @return JsonResponse
     */
    public function login(array $credentials): JsonResponse
    {
        if (! $token = auth()->attempt($credentials)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        return $this->respondWithToken($token);
    }
    /**
     *
     * @return JsonResponse
     */
    public function authUser(): JsonResponse
    {
        return (new UserResource(auth()->user()))->response();
    }
    /**
     *
     * @return JsonResponse
     */
    public function refreshToken(): JsonResponse
    {
        return $this->respondWithToken(auth()->refresh());
    }
    /**
     *
     * @return JsonResponse
     */
    public function logout(): JsonResponse
    {
        auth()->logout();

        return response()->json(['message' => 'Successfully logged out']);
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
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60
        ]);
    }
    
}