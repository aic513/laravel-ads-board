<?php
declare(strict_types=1);

namespace App\Http\Requests\Banner;

use Illuminate\Foundation\Http\FormRequest;

class EditRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string',
            'limit' => 'required|integer',
            'url' => 'required|url',
        ];
    }
}
