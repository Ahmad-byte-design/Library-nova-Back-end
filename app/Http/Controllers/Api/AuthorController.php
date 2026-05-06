<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Author\StoreAuthorRequest;
use App\Http\Requests\Author\UpdateAuthorRequest;
use App\Http\Resources\AuthorResource;
use App\Models\Author;
use App\Services\AuthorService;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

/**
 * @OA\Tag(
 *      name="Author",
 *      description="api for authors (admin only)"
 * )
 */
class AuthorController extends Controller
{
    use AuthorizesRequests;

    protected $authorService;

    public function __construct(AuthorService $authorService)
    {
        $this->authorService = $authorService;
    }

    /**
     * @OA\Get(
     *   path="/authors",
     *   summary="get all the authors",
     *   tags={"Authors"},
     *   security={{"bearerAuth":{}}},
     *
     *   @OA\Response(
     *      response="200",
     *      description="succeful operation",
     *
     *      @OA\JsonContent(
     *          type="array",
     *
     *          @OA\Items(ref="#/components/schemas/AuthorResource")
     * )
     *   )
     * )
     */
    public function index()
    {
        $authors = $this->authorService->getAllAuthors();

        return response()->json(AuthorResource::collection($authors), 200);
    }

    /**
     * @OA\Post(
     *      path="/authors",
     *      summary="create author (admin only)",
     *      tags={"Authors"},
     *      security={{"bearerAuth":{}}},
     *
     *      @OA\RequestBody(
     *          required = true,
     *
     *          @OA\JsonContent(ref="#/components/schemas/StoreAuthorRequest")
     *      ),
     *
     *      @OA\Response(
     *          response="201",
     *          description="author created successful",
     *
     *          @OA\JsonContent(ref="#/components/schemas/AuthorResource")
     *      )
     *  )
     */
    public function store(StoreAuthorRequest $request)
    {

        $this->authorize('create', Author::class);
        $author = $this->authorService->addAuthor($request->validated());

        return response()->json(new AuthorResource($author), 201);
    }

    /**
     * @OA\Get(
     *      path = "/authors/{id}",
     *      summary = "get a single author by id",
     *      tags = {"Authors"},
     *      security={{"bearerAuth":{}}},
     *
     *      @OA\Parameter(
     *          name="id",
     *          in="path",
     *          required=true,
     *
     *           @OA\Schema(type = "integer")
     * ),
     *
     *      @OA\Response(
     *          response="200",
     *          description = "successfull operation",
     *
     *          @OA\JsonContent(ref="#/components/schemas/AuthorResource")
     * )
     * )
     */
    public function show(string $id)
    {
        $author = $this->authorService->getAuthorById($id);

        return response()->json(new AuthorResource($author), 200);
    }

    /**
     * @OA\Put(
     *  path="/authors/{id}",
     * summary = "update the author (admin only)",
     * tags={"Authors"},
     * security={{"bearerAuth":{}}},
     *
     * @OA\Parameter(
     *     name="id",
     * in="path",
     * required=true,
     *
     * @OA\Schema(type="integer")
     * ),
     *
     * @OA\RequestBody(
     *  required=true,
     *
     * @OA\JsonContent(ref="#/components/schemas/UpdateAuthorRequest")
     * ),
     *
     * @OA\Response(
     *  response="201",
     * description="successfull operation",
     *
     * @OA\JsonContent(ref="#/components/schemas/AuthorResource")
     * )
     * )
     */
    public function update(UpdateAuthorRequest $request, string $id)
    {
        $author = Author::findOrFail($id);

        $this->authorize('update', $author);

        $author = $this->authorService->updateAuthor($id, $request->validated());

        return response()->json(new AuthorResource($author), 201);
    }

    /**
     * @OA\Delete(
     *    path="/authors/{id}",
     *      summary="delete the author (admin only)",
     *      tags={"Authors"},
     *      security={{"bearerAuth":{}}},
     *
     *     @OA\Parameter(
     *      name="id",
     *      in="path",
     *      required=true,
     *
     *      @OA\Schema(type="integer")
     * ),
     *
     * @OA\Response(
     *  response="204",
     *  description="author deleted successfully"
     * )
     * )
     */
    public function destroy(string $id)
    {
        //

        $author = Author::findOrFail($id);

        $this->authorize('delete', $author);

        $this->authorService->deleteAuthor($id);

        return response()->json(null, 204);
    }
}
