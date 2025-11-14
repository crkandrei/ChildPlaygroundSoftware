<?php

namespace App\Http\Requests\Scan;

use Illuminate\Foundation\Http\FormRequest;

class AssignBraceletRequest extends FormRequest
{
    public function authorize(): bool
    {
        return \Illuminate\Support\Facades\Auth::check();
    }

    public function rules(): array
    {
        return [
            'bracelet_code' => [
                'required',
                'string',
                'regex:/^BONGO\d{4,5}$/',
            ],
            'child_id' => ['required', 'exists:children,id'],
            'is_birthday' => ['nullable', 'boolean'],
        ];
    }

    public function messages(): array
    {
        return [
            'bracelet_code.regex' => 'Cod invalid. Format așteptat: BONGO urmat de 4 sau 5 cifre (ex: BONGO1234)',
        ];
    }

    protected function failedValidation(\Illuminate\Contracts\Validation\Validator $validator)
    {
        if ($this->expectsJson() || $this->is('scan-api/*')) {
            throw new \Illuminate\Validation\ValidationException($validator);
        }
        
        parent::failedValidation($validator);
    }
}


