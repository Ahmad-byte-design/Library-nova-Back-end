<?php

namespace App\Http\Requests\Category;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

/**
 *  @OA\Schema(
 *      schema="UpdateCategoryRequest",
 *       required={"name"},
 *
 * @OA\Property(property="name", type="string" , example="example"),
 * @OA\Property(property="icon", type="string" ,format="binary", description="icon image"),
 *
 * )
 */

class UpdateCategoryRequest extends FormRequest
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
            "name"=>"sometimes|string",
            "icon"=>"nullable|file|mimes:jpg,jpeg,png,webp|max:4096"
        ];
    }
}
