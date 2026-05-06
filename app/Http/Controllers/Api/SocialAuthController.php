<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\SocialAuthService;

class SocialAuthController extends Controller
{
    protected $socialAuthService;

    public function __construct(SocialAuthService $socialAuthService)
    {
        $this->socialAuthService = $socialAuthService;
    }

    /**
     * @OA\Get(
     *     path="/auth/{provider}/redirect",
     *     summary="Get OAuth redirect URL",
     *     tags={"Auth"},
     *
     *     @OA\Parameter(
     *         name="provider",
     *         in="path",
     *         required=true,
     *
     *         @OA\Schema(type="string", enum={"google"})
     *     ),
     *
     *     @OA\Response(
     *         response=200,
     *         description="Redirect URL",
     *
     *         @OA\JsonContent(
     *             type="object",
     *
     *             @OA\Property(property="redirect_url", type="string", example="https://accounts.google.com/...")
     *         )
     *     ),
     *
     *     @OA\Response(response=400, description="Invalid provider")
     * )
     */
    public function redirectToProvider(string $provider)
    {
        $validProviders = ['google'];
        if (! in_array($provider, $validProviders)) {
            return response()->json(['error' => 'invalide provider'], 400);
        }
        $redirectUrl = $this->socialAuthService->getRedirectUrl($provider);

        return response()->json(['redirect_url' => $redirectUrl], 200);
    }

    /**
     * @OA\Get(
     *     path="/auth/{provider}/callback",
     *     summary="OAuth callback",
     *     tags={"Auth"},
     *
     *     @OA\Parameter(
     *         name="provider",
     *         in="path",
     *         required=true,
     *
     *         @OA\Schema(type="string", enum={"google", "facebook"})
     *     ),
     *
     *     @OA\Parameter(
     *         name="code",
     *         in="query",
     *         required=true,
     *
     *         @OA\Schema(type="string")
     *     ),
     *
     *     @OA\Parameter(
     *         name="state",
     *         in="query",
     *         required=true,
     *
     *         @OA\Schema(type="string")
     *     ),
     *
     *     @OA\Response(
     *         response=200,
     *         description="Successful login",
     *
     *         @OA\JsonContent(
     *             type="object",
     *
     *             @OA\Property(property="user", type="object"),
     *             @OA\Property(property="token", type="string"),
     *             @OA\Property(property="token_type", type="string", example="Bearer")
     *         )
     *     ),
     *
     *     @OA\Response(response=422, description="Invalid credentials")
     * )
     */
    public function handleProviderCallback(string $provider)
    {
        try {
            $result = $this->socialAuthService->authenticate($provider);

            return response()->json($result);
        } catch (\Exception $e) {
            return response()->json(['error' => 'invalid credentials provider' . $e->getMessage() ], 422);
        }
    }
}
