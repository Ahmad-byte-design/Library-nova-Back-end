<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;



/**
 * @OA\Schema(
 *     schema="BookResource",
 *     @OA\Property(property="id",             type="integer", example=1),
 *     @OA\Property(property="ISBN",           type="string",  example="9781234567897"),
 *     @OA\Property(property="title",          type="string",  example="Clean Architecture"),
 *     @OA\Property(property="description",    type="string",  example="A book about clean architecture"),
 *     @OA\Property(property="published_date", type="string",  format="date", example="2024-01-01"),
 *     @OA\Property(property="category_id",    type="integer", example=1),
 *     @OA\Property(property="author_id",      type="integer", example=1)
 * )
 */

class BookResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */

    public function toArray(Request $request): array
    {


        return [
            'id'=>$this->id,
            'isbn'=>$this->ISBN,
            'title'=>$this->title,
            'description'=> $this->description,
            'published_date'=>$this->published_date,
            'image'=>$this->image_url,
            'book_upload'=>$this->book_upload_url,
            "author"=>new AuthorResource($this->whenLoaded("author")),
            "category"=>new CategoryResource($this->whenLoaded("category")),
            'created_at'=>$this->created_at->diffForHumans()
        ];

    }
}
