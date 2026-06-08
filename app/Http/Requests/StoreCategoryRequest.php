<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreCategoryRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation()
    {
        $input = $this->all();
        array_walk($input, function (&$val) {
            if (is_string($val)) {
                $val = trim(strip_tags($val));
            }
        });
        $this->merge($input);
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|unique:categories,name',
        ];
    }

    public function messages(): array
    {
        return [
            'name.unique' => 'Nama kategori sudah ada.',
        ];
    }
}