<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\FavoriteService;

use Illuminate\Http\Request;



/**
 * @OA\Tag(
 *      name="Favorites",
 *      description="api for favorites"
 *  )
 */

class FavoriteController extends Controller
{


    protected $favoriteService;

    public function __construct(FavoriteService $favoriteService)
    {
        $this->favoriteService = $favoriteService;
    }

       /**
        * @OA\Post(
     *      path="/books/{book_id}/favorites",
     *      summary="add book to favorities lists",
     *      tags={"Favorites"},
     *      security={{"bearerAuth":{}}},
     *      @OA\Parameter(
     *          name="book_id",
     *          in="path",
     *          required=true,
     *          @OA\Schema(type="integer")
     *      ),
     *      @OA\Response(
     *          response="201",
     *          description="book has been add it to the favorites",
     *          @OA\JsonContent(
     *              @OA\Property(property="message",type="string" , example="add book to favorities lists")
     *          )
     *      ),
     *      @OA\Response(
     *          response="401",
     *          description="unauthenticated",
     *      ),
     * )
     */


    public function store(Request $request, $bookId)
    {
        $user = $request->user();
        $this->favoriteService->addFavorite($user, $bookId);

        return response()->json(['message' => 'book add to favorites'], 201);
    }


      /**
     * @OA\Delete(
     *      path="/books/{book_id}/favorites",
     *      summary="remove the book from favorites list",
     *      tags={"Favorites"},
     *      security={{"bearerAuth":{}}},
     *      @OA\Parameter(
     *          name="book_id",
     *          in="path",
     *          required=true,
     *          @OA\Schema(type="integer")
     *      ),
     *      @OA\Response(
     *          response="200",
     *          description="book has been removed from the favorites",
     *          @OA\JsonContent(
     *              @OA\Property(property="message",type="string" , example="book removed from favorites")
     *          )
     *      ),
     *      @OA\Response(
     *          response="401",
     *          description="unauthenticated",
     *      ),
     *  )
     */

    public function destroy(Request $request,$bookId){
        $user = $request->user();
        $this->favoriteService->removeFavorite($user, $bookId);

        return response()->json(['message' => 'book removed from favorites'], 200);
    }
}
