<?php

namespace App\Http\Requests\V1\Admin\Token;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @OA\Schema(
 *      title="Store Token request",
 *      description="Store Token request body data",
 *      type="object",
 *      required={"email", "password", "device_name"}
 * ),
 * @OA\Property(
 *     property="email",
 *     type="string",
 *     title="Email",
 *     example="admin@admin.com",
 * ),
 * @OA\Property(
 *     property="password",
 *     type="string",
 *     title="Password",
 *     example="demo1234",
 * ),
 * @OA\Property(
 *     property="device_name",
 *     type="string",
 *     title="Device name",
 *     example="test",
 * )
 */
class StoreTokenRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'email' => 'required|email',
            'password' => 'required|string',
            'device_name' => 'required',
        ];
    }
}
