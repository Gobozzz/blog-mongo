<?php

declare(strict_types=1);

namespace App\Http\Requests\Post;

use App\DTO\Post\PostCreateDTO;
use Illuminate\Foundation\Http\FormRequest;

class PostStoreRequest extends FormRequest
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
            'title' => ['required', 'string', 'max:100'],
            'content' => ['required', 'string', 'max:1000'],
            'tags' => ['nullable', 'array', 'max:3'],
        ];
    }

    public function getDTO(): PostCreateDTO
    {
        return new PostCreateDTO(
            title: $this->input('title'),
            content: $this->input('content'),
            userId: $this->user()->getKey(),
            tagsIds: $this->input('tags', []),
        );
    }
}
