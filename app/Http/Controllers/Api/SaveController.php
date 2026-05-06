<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\SaveService;
use Illuminate\Http\Request;

/**
 * @OA\Tag(
 *      name="Saves",
 *      description="api for saving"
 *  )
 */
class SaveController extends Controller
{
    protected $saveService;

    public function __construct(SaveService $saveService)
    {
        $this->saveService = $saveService;
    }

    /**
     * @OA\Post(
     *      path="/books/{book_id}/saves",
     *      summary="create a new review for book",
     *      tags={"Saves"},
     *      security={{"bearerAuth":{}}},
     *      @OA\Parameter(
     *          name="book_id",
     *          in="path",
     *          required=true,
     *          @OA\Schema(type="integer")
     *      ),
     *      @OA\Response(
     *          response="200",
     *          description="book has been add it to the saves",
     *          @OA\JsonContent(
     *              @OA\Property(property="message",type="string" , example="book add it to saves")
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
        $this->saveService->addSave($user, $bookId);

        return response()->json(['message' => 'book add to saves'], 201);
    }

    /**
     * @OA\Delete(
     *      path="/books/{book_id}/saves",
     *      summary="remove the book from saves list",
     *      tags={"Saves"},
     *      security={{"bearerAuth":{}}},
     *      @OA\Parameter(
     *          name="book_id",
     *          in="path",
     *          required=true,
     *          @OA\Schema(type="integer")
     *      ),
     *      @OA\Response(
     *          response="201",
     *          description="book has been removed from the saves",
     *          @OA\JsonContent(
     *              @OA\Property(property="message",type="string" , example="book removed from saves")
     *          )
     *      ),
     *      @OA\Response(
     *          response="401",
     *          description="unauthenticated",
     *      ),
     *  )
     */

    public function destroy(Request $request, $bookId)
    {
        $user = $request->user();
        $this->saveService->removeSave($user, $bookId);

        return response()->json(['message' => 'book removed from saves'], 200);
    }


    /**
 * @OA\Post(
 *     path="/booko/books",
 *     summary="Upload a book file",
 *     tags={"Test"},
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\MediaType(
 *             mediaType="multipart/form-data",
 *             @OA\Schema(
 *                 @OA\Property(
 *                     property="file",
 *                     type="string",
 *                     format="binary",
 *                     description="The file to upload"
 *                 )
 *             )
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="File uploaded successfully"
 *     ),
 *     @OA\Response(
 *         response=400,
 *         description="No file provided"
 *     )
 * )
 */
}
