<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Review\StoreReviewRequest;
use App\Http\Requests\Review\UpdateReviewRequest;
use App\Http\Resources\ReviewResource;
use App\Services\ReviewService;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

/**
 * @OA\Tag(
 *  name="reviews",
 *  description="api for managing reviews"
 * )
 */


class ReviewController extends Controller
{

    use AuthorizesRequests;


    protected $reviewService;

    public function __construct(ReviewService $reviewService)
    {
        $this->reviewService = $reviewService;

    }

     /**
     *  @OA\Get(
     *      path="/books/{book_id}/reviews",
     *      summary="Get all reviews for one book by id",
     *      tags={"Reviews"},
     *      security={{"bearerAuth":{}}},
     *      @OA\Parameter(
     *          name="book_id",
     *          in="path",
     *          required=true,
     *          @OA\Schema(type="integer")
     *      ),
    *      @OA\Response(
    *          response="200",
    *          description="successful operation",
    *          @OA\JsonContent(ref="#/components/schemas/ReviewResource")
    *      )
     * )
     */
    public function show(string $book_id)
    {
        $reviews= $this->reviewService->getAllReviewsOfBook($book_id);

        return response()->json(ReviewResource::collection($reviews),200);
    }



    /**
     *  @OA\Post(
     *      path="/reviews",
     *      summary="create a  review",
     *      tags={"Reviews"},
     *      security={{"bearerAuth":{}}},
    *      @OA\RequestBody(
    *          required=true,
    *          @OA\JsonContent(ref="#/components/schemas/StoreReviewRequest")
    *      ),
    *      @OA\Response(
    *          response="201",
    *          description="review created successfully",
    *          @OA\JsonContent(ref="#/components/schemas/ReviewResource")
    *      )
     * )
     */
    public function store(StoreReviewRequest $request)
    {
        //
        $data = $request->validated();
        $data["user_id"] = auth()->id();
        $review = $this->reviewService->addReview($data);
        return response()->json(new ReviewResource($review) , 201 );
    }

   /**
     *  @OA\Put(
     *      path="/reviews/{id}",
     *      summary="update review",
     *      tags={"Reviews"},
     *      security={{"bearerAuth":{}}},
     *      @OA\Parameter(
     *          name="id",
     *          in="path",
     *          required=true,
     *          @OA\Schema(type="integer")
     *      ),
     *
    *      @OA\RequestBody(
    *          required=true,
    *          @OA\JsonContent(ref="#/components/schemas/UpdateReviewRequest")
    *      ),
    *      @OA\Response(
    *          response="200",
    *          description="review updated successful ",
    *          @OA\JsonContent(ref="#/components/schemas/ReviewResource")
    *      )
     * )
     */
    public function update(UpdateReviewRequest $request, string $id)
    {
        //
        $review =$this->reviewService->updateReview($id,$request->validated());

        // $this->authorize('update',$review);
        return response()->json(new ReviewResource($review) , 201);
    }


    /**
     *  @OA\Delete(
     *      path="/reviews/{id}",
     *      summary="delete a review",
     *      tags={"Reviews"},
     *      security={{"bearerAuth":{}}},
     *      @OA\Parameter(
     *          name="id",
     *          in="path",
     *          required=true,
     *          @OA\Schema(type="integer")
     *      ),
     *      @OA\Response(
     *          response="204",
     *          description="review deleted successful",
     *      )
     * )
     */
    public function destroy(string $id)
    {
        //

        $this->reviewService->deleteReview($id);
        return response()->json(null,204);
    }
}
