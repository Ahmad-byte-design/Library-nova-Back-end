<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @OA\Schema(
 *     schema="AuthResource",
 *     @OA\Property(property="id",             type="integer", example=1),
 *     @OA\Property(property="name",           type="string",  example="example"),
 *     @OA\Property(property="email",          type="email",  example="example@gmail.com"),
 * )
 */

class AuthResource extends JsonResource
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
            "email"=>$this->email
        ];
    }
}
