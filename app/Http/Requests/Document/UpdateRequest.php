<?php

namespace App\Http\Requests\Document;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\UploadedFile;

class UpdateRequest extends FormRequest
{
    public function getUserId(): int
    {
        return $this->user()->id;
    }

    public function isUserAdmin(): bool
    {
        return $this->user()->isAdmin();
    }

    public function getFile(): UploadedFile|null
    {
        return $this->file('file');
    }

    public function getName(): string|null
    {
        return $this->input('name');
    }

    public function getDocumentId(): string
    {
        return $this->input('document_id');
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
            'name' => 'nullable|string',
            'file' => 'nullable|file|mimes:docx,pdf',
            'document_id' => 'required|integer',
        ];
    }
}
