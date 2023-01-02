<?php

namespace App\Http\Requests\V1\Admin\Token;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @OA\Schema(
 *      title="Destroy Token request",
 *      description="Destroy Token request body data",
 *      type="object",
 *      required={"device_name"}
 * ),
 *  * @OA\Property(
 *     property="device_name",
 *     type="string",
 *     title="Device name",
 *     example="test",
 * )
 */
class DestroyTokenRequest extends FormRequest
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
            'device_name' => 'required',
        ];
    }
}
