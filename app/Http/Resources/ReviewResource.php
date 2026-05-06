<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 *  @OA\Schema(
 *      schema="ReviewResource",
 *
 * @OA\Property(property="id", type="integer" , example=1),
 * @OA\Property(property="comments", type="string" , example="example"),
 * @OA\Property(property="rating", type="integer" , example=3),
 * @OA\Property(property="book_id", type="integer" , example=1),
 * @OA\Property(property="user", ref="#/components/schemas/UserResource"),
 *
 * )
 */


class ReviewResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "id"=>$this->id,
            "comments"=>$this->comments,
            "rating"=>$this->rating,
            "book_id"=>$this->book_id,
            "user"=>new UserResource($this->whenLoaded("user")),
            "created_at"=>$this->created_at->diffForHumans()
        ];
    }
}
