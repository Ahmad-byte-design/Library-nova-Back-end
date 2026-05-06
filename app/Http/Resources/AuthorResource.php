<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;


/**
 * @OA\Schema(
 *  schema="AuthorResource",
 * @OA\Property(property="id" , type="integer",example=1),
 *  @OA\Property(property="name",type="string" , example="example"),
 *  @OA\Property(property="date_of_birth",type="date" , example="2020-2-2"),
 *  @OA\Property(property="information",type="string" , example="example info."),
 * )
 */

class AuthorResource extends JsonResource
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
            "name"=>$this->name,
            "date_of_birth"=>$this->date_of_birth,
            "information"=>$this->information
        ];
    }
}
