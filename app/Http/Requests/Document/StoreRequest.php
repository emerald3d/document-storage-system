<?php

namespace App\Http\Requests\Document;

use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string',
            'file' => 'required|file|mimes:docx,pdf',
        ];
    }

    private array $messages = [
        'file.required' => 'Файл в документе обязателен.',
        'file.mimetypes' => 'Допущены только некоторые форматы документов (в тз ясно не сказано).',
    ];

    public function messages(): array {
        return $this->messages;
    }
}
