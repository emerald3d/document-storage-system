<?php

namespace App\Http\Requests\Document;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\UploadedFile;

class StoreRequest extends FormRequest
{
    public function getUserId(): int
    {
        return $this->user()->id;
    }

    public function getFile(): UploadedFile
    {
        return $this->file('file');
    }

    public function getName(): string
    {
        return $this->input('name');
    }
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
        'file.mimes' => 'Файл должен быть формата .docx или .pdf.',
    ];

    public function messages(): array {
        return $this->messages;
    }
}
