<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Repositories\Interfaces\ApiAuthInterface;
use App\Http\Requests\auth\LoginRequest;
use App\Http\Requests\auth\RegisterRequest;
use Illuminate\Http\JsonResponse;

class AuthController extends Controller
{
    /**
    *
    * @var $repo
    *
    */
    private $repo;
    
    /**
    *
    * @param ApiAuthInterface $repo
    *
    */
    public function __construct(ApiAuthInterface $repo)
    {
        $this->repo = $repo;
        $this->middleware('auth:api', ['except' => ['login','register']]);
    }
    /**
     *
     * @param RegisterRequest $request
     * @return JsonResponse
     */
    public function register(RegisterRequest $request) :JsonResponse{
        return $this->repo->register($request->all());
    }
    /**
     *
     * @param LoginRequest $request
     * @return JsonResponse
     */
    public function login(LoginRequest $request) :JsonResponse{
        return $this->repo->login($request->only(['email','password']));
    }
    /**
     *
     * @return JsonResponse
     */
    public function authUser():JsonResponse{
        return $this->repo->authUser();
    }
    /**
     *
     * @return JsonResponse
     */
    public function refreshToken() :JsonResponse{
        return $this->repo->refreshToken();
    }
    /**
     *
     * @return JsonResponse
     */
    public function logout(){
        return $this->repo->logout();
    }
}
