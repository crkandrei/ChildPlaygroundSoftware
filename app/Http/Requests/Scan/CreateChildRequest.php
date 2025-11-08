<?php

namespace App\Http\Requests\Scan;

use Illuminate\Foundation\Http\FormRequest;

class CreateChildRequest extends FormRequest
{
    public function authorize(): bool
    {
        return \Illuminate\Support\Facades\Auth::check();
    }

    public function rules(): array
    {
        $maxDate = now()->subDay()->format('Y-m-d'); // Yesterday
        $minDate = now()->subYears(18)->format('Y-m-d'); // 18 years ago
        
        return [
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'birth_date' => ['required', 'date', "before:today", "after_or_equal:{$minDate}"],
            'allergies' => ['nullable', 'string', 'max:500'],
            // Either guardian_id OR guardian_* fields (enforced in withValidator)
            'guardian_id' => ['nullable', 'integer', 'exists:guardians,id'],
            'guardian_name' => ['nullable', 'string', 'max:255'],
            'guardian_phone' => ['nullable', 'string', 'max:20'],
            'bracelet_code' => ['required', 'string', 'min:1', 'max:255'],
        ];
    }

    protected function prepareForValidation(): void
    {
        // Normalize empty strings to null for guardian optional fields
        $this->merge([
            'guardian_name' => $this->normalizeEmpty($this->input('guardian_name')),
            'guardian_phone' => $this->normalizeEmpty($this->input('guardian_phone')),
        ]);
    }

    private function normalizeEmpty($value)
    {
        if (is_string($value)) {
            $trimmed = trim($value);
            return $trimmed === '' ? null : $trimmed;
        }
        return $value;
    }

    public function messages(): array
    {
        $minDate = now()->subYears(18)->format('d.m.Y');
        
        return [
            'birth_date.required' => 'Data nașterii este obligatorie.',
            'birth_date.date' => 'Data nașterii nu este validă.',
            'birth_date.before' => 'Data nașterii nu poate fi în viitor sau astăzi.',
            'birth_date.after_or_equal' => "Data nașterii indică un copil mai mare de 18 ani. Copilul trebuie să aibă maximum 18 ani (data minimă: {$minDate}).",
        ];
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            $data = $this->all();
            $hasId = !empty($data['guardian_id']);
            $hasNew = !empty($data['guardian_name']);

            if (!$hasId && !$hasNew) {
                $validator->errors()->add('guardian', 'Alege părinte existent sau introdu date părinte.');
            }
            if ($hasId && $hasNew) {
                $validator->errors()->add('guardian', 'Nu poți trimite și guardian_id și date părinte.');
            }

            // When creating a new guardian, require minimal fields
            if ($hasNew) {
                if (empty($data['guardian_phone'])) {
                    $validator->errors()->add('guardian_phone', 'Telefonul părintelui este necesar.');
                }
            }
        });
    }

    protected function failedValidation(\Illuminate\Contracts\Validation\Validator $validator)
    {
        if ($this->expectsJson() || $this->is('scan-api/*')) {
            throw new \Illuminate\Validation\ValidationException($validator);
        }
        
        parent::failedValidation($validator);
    }
}


