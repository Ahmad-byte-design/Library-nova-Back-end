<?php

namespace App\Http\Requests\Auth;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;



/**
 * @OA\Schema(
 *     schema="RegisterRequest",
 *     required={"name","email","password" , "password_confirmation"},
 *     @OA\Property(property="name",           type="string",  example="example"),
 *     @OA\Property(property="email",           type="email",  example="example@gmail.com"),
 *     @OA\Property(property="password",          type="string",  example="123456789"),
 *     @OA\Property(property="password_confirmation",          type="string",  example="123456789"),
 * )
 */


class RegisterRequest extends FormRequest
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
            "email"=>"required|email|unique:users",
            "password"=>"required|string|min:8|confirmed"
        ];
    }
}
