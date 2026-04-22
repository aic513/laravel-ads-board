<?php
declare(strict_types=1);

namespace App\Http\Requests\Cabinet;

use Illuminate\Foundation\Http\FormRequest;
use Swagger\Annotations as SWG;

/**
 * @SWG\Definition(
 *     definition="ProfileEditRequest",
 *     type="object",
 *     @SWG\Property(property="name", type="string"),
 *     @SWG\Property(property="last_name", type="string"),
 *     @SWG\Property(property="phone", type="string"),
 * )
 */
class ProfileEditRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'phone' => 'required|string|max:255|regex:/^\d+$/s',
        ];
    }
}
