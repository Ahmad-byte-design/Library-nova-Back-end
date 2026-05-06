<?php

namespace App\Http\Requests\Author;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;




/** @OA\Schema(
 *  schema="UpdateAuthorRequest",
 *  required={"name","date_of_birth","information"},
 *  @OA\Property(property="name",type="string" , example="example"),
 *  @OA\Property(property="date_of_birth",type="date" , example="2020-2-2"),
 *  @OA\Property(property="information",type="string" , example="example info."),
 * )
 *
 */


class UpdateAuthorRequest extends FormRequest
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
            'name' => 'sometimes|string',
            'date_of_birth' => 'sometimes|date',
            'information' => 'sometimes|string',
        ];
    }
}
