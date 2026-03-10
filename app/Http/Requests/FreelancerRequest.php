<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FreelancerRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        // You keep this as true, if you will be the one to establish the validation
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
            'name' => ['required', 'string'],
            'email' => ['required', 'email', 'unique:freelancers,email'],
            'github_username' => ['required', 'string', 'unique:freelancers,github_username']
        ];
    }
}
