<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Http\Resources\AuthResource;
use App\Services\AuthService;
use Illuminate\Http\Request;

/**
 * @OA\Tag(
 *  name="Auth",
 *  description="api for auth system"
 * )
 */
class AuthController extends Controller
{
    protected $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    /**
     * @OA\Post(
     *  path="/login",
     *  summary="user login",
     *  tags={"Auth"},
     *
     *  @OA\RequestBody(
     *  required=true,
     *
     *  @OA\JsonContent(ref="#/components/schemas/LoginRequest")
     * ),
     *
     * @OA\Response(
     *  response="200",
     *  description="login successfully!",
     *
     *  @OA\JsonContent(ref="#/components/schemas/AuthResource")
     * )
     * )
     */
    public function login(LoginRequest $credintial)
    {
        $data = $credintial->only(['email', 'password']);
        $user = $this->authService->login($data);

        return response()->json([
            'user' => new AuthResource($user['user']),
            'token' => $user['token'],
        ], 200);
    }

    /**
     * @OA\Post(
     *  path="/register",
     *  summary="user register",
     * tags={"Auth"},
     *
     * @OA\RequestBody(
     *   required=true,
     *
     *          @OA\JsonContent(ref="#/components/schemas/RegisterRequest")
     * ),
     *
     * @OA\Response(
     *  response="201",
     *  description="user has been register successfully!",
     *
     *  @OA\JsonContent(ref="#/components/schemas/AuthResource")
     * )
     * )
     */
    public function register(RegisterRequest $credintial)
    {
        $user = $this->authService->register($credintial->validated());

        return response()->json([
            'user' => new AuthResource($user['user']),
            'token' => $user['token'],
            'token_type' => 'Bearer',
        ], 201);
    }

    /**
     * @OA\Post(
     *  path="/logout",
     *  summary="logout from your account",
     * tags={"Auth"},
     * security={{"bearerAuth": {}}},
     *
     *  @OA\Response(
     *      response="204",
     *      description="user logged out successfully"
     *  ),
     *  @OA\Response(
     *      response="401",
     *      description="Unauthenticated"
     *  )
     * )
     */
    public function logout(Request $request)
    {
        $this->authService->logout($request->user());

        return response()->json(['message' => 'logged out'], 204);
    }
}
