<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateTaskRequest extends FormRequest
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
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        if ($this->user()?->isTester()) {
            return [
                'comment' => ['nullable', 'string', 'max:2000'],
            ];
        }

        return [
            'name' => ['required', 'string', 'max:255'],
            'duration_hours' => ['required', 'integer', 'min:1'],
            'assigned_to' => ['required', 'exists:users,id'],
            'comment' => ['nullable', 'string', 'max:2000'],
        ];
    }
}
