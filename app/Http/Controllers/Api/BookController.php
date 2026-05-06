<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Book\StoreBookRequest;
use App\Http\Requests\Book\UpdateBookRequest;
use App\Http\Resources\BookResource;
use App\Models\Book;
use App\Services\BookService;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

/**
 * @OA\Tag(
 *  name="books",
 *  description="api for managing books"
 * )
 */
class BookController extends Controller
{
    use AuthorizesRequests;

    protected $bookService;

    public function __construct(BookService $bookService)
    {
        $this->bookService = $bookService;
    }

    /**
     *  @OA\Get(
     *      path="/books",
     *      summary="Get a paginated list of all books",
     *      tags={"Books"},
     *      security={{"bearerAuth":{}}},
     *      @OA\Response(
     *          response="200",
     *          description="successful operation",
     *          @OA\JsonContent(
     *          type="array",
     *          @OA\Items(ref="#/components/schemas/BookResource")
     *          )
     *      )
     * )
     */
    public function index()
    {
        $books = $this->bookService->getAllBooks();
        return response()->json(BookResource::collection($books), 200);
    }

    /**
     *  @OA\Post(
     *      path="/books",
     *      summary="create a  book (Admin ONLY)",
     *      tags={"Books"},
     *      security={{"bearerAuth":{}}},
     *
     *      @OA\RequestBody(
     *          required=true,
     *
     *          @OA\MediaType(
     *              mediaType="multipart/form-data",
     *              @OA\Schema(ref="#/components/schemas/StoreBookRequest")
     *              )
     *      ),
     *
     *      @OA\Response(
     *          response="201",
     *          description="Book created successfully",
     *
     *          @OA\JsonContent(ref="#/components/schemas/BookResource")
     *      )
     * )
     */
    public function store(StoreBookRequest $request)
    {
        //

        $this->authorize('create', Book::class);

        $book = $this->bookService->addBook($request->validated());

        return response()->json(new BookResource($book), 201);
    }

    /**
     *  @OA\Get(
     *      path="/books/{id}",
     *      summary="Get a single book by id",
     *      tags={"Books"},
     *      security={{"bearerAuth":{}}},
     *
     *      @OA\Parameter(
     *          name="id",
     *          in="path",
     *          required=true,
     *
     *          @OA\Schema(type="integer")
     *      ),
     *
     *      @OA\Response(
     *          response="200",
     *          description="successful operation",
     *
     *          @OA\JsonContent(ref="#/components/schemas/BookResource")
     *      )
     * )
     */
    public function show(string $id)
    {
        //
        $book = $this->bookService->getBookById($id);

        return response()->json(new BookResource($book), 200);
    }

    /**
     *  @OA\Put(
     *      path="/books/{id}",
     *      summary="update a book (Admin only)",
     *      tags={"Books"},
     *      security={{"bearerAuth":{}}},
     *
     *      @OA\Parameter(
     *          name="id",
     *          in="path",
     *          required=true,
     *
     *          @OA\Schema(type="integer")
     *      ),
     *
     *      @OA\RequestBody(
     *          required=true,
     *
     *          @OA\MediaType(
     *              mediaType = "multipart/form-data",
     *              @OA\Schema(ref="#/components/schemas/UpdateBookRequest")
     *             )
     *      ),
     *
     *      @OA\Response(
     *          response="200",
     *          description="Book updated successful (admin only)",
     *
     *          @OA\JsonContent(ref="#/components/schemas/BookResource")
     *      )
     * )
     */
    public function update(UpdateBookRequest $request, string $id)
    {
        //
        $book = Book::findOrFail($id);

        $this->authorize('update', $book);

        $book = $this->bookService->updateBook($id, $request->validated());

        return response()->json(new BookResource($book), 201);
    }

    /**
     *  @OA\Delete(
     *      path="/books/{id}",
     *      summary="delete a book (admin only)",
     *      tags={"Books"},
     *      security={{"bearerAuth":{}}},
     *
     *      @OA\Parameter(
     *          name="id",
     *          in="path",
     *          required=true,
     *
     *          @OA\Schema(type="integer")
     *      ),
     *
     *      @OA\Response(
     *          response="204",
     *          description="book deleted successful (admin only)",
     *      )
     * )
     */
    public function destroy(string $id)
    {
        $book = Book::findOrFail($id);

        $this->authorize('delete', $book);

        $this->bookService->deleteBook($id);

        return response()->json(null, 204);
    }
}
