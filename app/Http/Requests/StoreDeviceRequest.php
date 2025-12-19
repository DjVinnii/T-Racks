<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreDeviceRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'rack_id' => ['nullable', 'uuid', 'exists:racks,id'],
            'name' => ['required', 'string', 'max:255'],
        ];
    }
}
