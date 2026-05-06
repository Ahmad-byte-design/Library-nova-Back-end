<?php

namespace App\Http\Requests\Book;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

/**
 * @OA\Schema(
 *     schema="UpdateBookRequest",
 *     @OA\Property(property="ISBN",           type="string",  example="9781234567897"),
 *     @OA\Property(property="title",          type="string",  example="Clean Architecture"),
 *     @OA\Property(property="description",    type="string",  example="A book about clean architecture"),
 *     @OA\Property(property="published_date", type="string",  format="date", example="2024-01-01"),
 *     @OA\Property(property="category_id",    type="integer", example=1),
 *     @OA\Property(property="author_id",      type="integer", example=1),
 *     @OA\Property(property="book_upload",    type="string",  format="binary", description="PDF File"),
 *     @OA\Property(property="image",          type="string",  format="binary", description="Cover image")
 * )
 */

class UpdateBookRequest extends FormRequest
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
            'ISBN' => 'sometimes|digits:13|unique:books',
            'title' => 'sometimes|string',
            'description' => 'sometimes|string',
            'published_date' => 'sometimes|date',
            'category_id' => 'sometimes|integer|exists:categories,id',
            'author_id' => 'sometimes|integer|exists:authors,id',
            'book_upload' => 'sometimes|file|mimes:pdf|max:51200',
            'image' => 'sometimes|file|mimes:jpg,jpeg,png,webp|max:4096',
        ];
    }
}
