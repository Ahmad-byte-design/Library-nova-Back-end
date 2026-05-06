<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\BookResource;
use Illuminate\Http\Request;

/**
 * @OA\Tag(
 *     name="User",
 *     description="api for authenticated user actions"
 * )
 */
class UserController extends Controller
{
    /**
     * @OA\Get(
     *     path="/favorites",
     *     summary="get the authenticated user's favorite books",
     *     tags={"Favorites"},
     *     security={{"bearerAuth":{}}},
     *
     *     @OA\Response(
     *         response="200",
     *         description="successful operation",
     *
     *         @OA\JsonContent(
     *             type="array",
     *
     *             @OA\Items(ref="#/components/schemas/BookResource")
     *         )
     *     ),
     *
     *     @OA\Response(
     *         response="401",
     *         description="unauthenticated"
     *     )
     * )
     */
    public function favorites(Request $request)
    {
        return response()->json(BookResource::collection($request->user()->favorites()->paginate(10)));
    }

    /**
     * @OA\Get(
     *     path="/saves",
     *     summary="get the authenticated user's saved books",
     *     tags={"Saves"},
     *     security={{"bearerAuth":{}}},
     *
     *     @OA\Response(
     *         response="200",
     *         description="successful operation",
     *
     *         @OA\JsonContent(
     *             type="array",
     *
     *             @OA\Items(ref="#/components/schemas/BookResource")
     *         )
     *     ),
     *
     *     @OA\Response(
     *         response="401",
     *         description="unauthenticated"
     *     )
     * )
     */
    public function saves(Request $request)
    {
        return response()->json(BookResource::collection($request->user()->saves()->paginate(10)));
    }
}
