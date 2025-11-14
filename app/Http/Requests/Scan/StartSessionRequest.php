<?php

namespace App\Http\Requests\Scan;

use Illuminate\Foundation\Http\FormRequest;

class StartSessionRequest extends FormRequest
{
    public function authorize(): bool
    {
        return \Illuminate\Support\Facades\Auth::check();
    }

    public function rules(): array
    {
        return [
            'child_id' => ['required', 'exists:children,id'],
            'bracelet_code' => [
                'required',
                'string',
                'regex:/^BONGO\d{4,5}$/',
            ],
            'is_birthday' => ['nullable', 'boolean'],
        ];
    }

    public function messages(): array
    {
        return [
            'bracelet_code.regex' => 'Cod invalid. Format așteptat: BONGO urmat de 4 sau 5 cifre (ex: BONGO1234)',
        ];
    }
}


