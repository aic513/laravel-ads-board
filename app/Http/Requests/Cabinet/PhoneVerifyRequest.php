<?php
declare(strict_types=1);

namespace App\Http\Requests\Cabinet;

use Illuminate\Foundation\Http\FormRequest;

class PhoneVerifyRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'token' => 'required|string|max:255',
        ];
    }
}
