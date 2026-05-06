<?php

namespace App\Http\Requests\Category;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

/**
 *  @OA\Schema(
 *      schema="StoreCategoryRequest",
 *       required={"name","icon"},
 *
 * @OA\Property(property="name", type="string" , example="example"),
 * @OA\Property(property="icon", type="string" ,format="binary", description="icon image"),
 *
 * )
 */
class StoreCategoryRequest extends FormRequest
{
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
            'name' => 'required|string',
            'icon' => 'nullable|file|mimes:jpg,jpeg,png,webp|max:4096',
        ];
    }
}
