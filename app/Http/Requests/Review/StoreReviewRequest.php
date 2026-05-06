<?php

namespace App\Http\Requests\Review;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

/**
 *  @OA\Schema(
 *      schema="StoreReviewRequest",
 *       required={"comments","rating","book_id"},
 *
 * @OA\Property(property="comments", type="string" , example="example"),
 * @OA\Property(property="rating", type="integer" , example=3),
 * @OA\Property(property="book_id", type="integer" , example=1),
 *
 * )
 */

class StoreReviewRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            "comments"=>"required|string",
            "rating"=>"required|integer|min:0|max:5",
            "book_id"=>"required|integer|exists:books,id"
        ];
    }
}
