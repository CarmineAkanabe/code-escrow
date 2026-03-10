<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class GigRequest extends FormRequest
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
            'freelancer_id' => ['required', 'integer', 'exists:freelancers,id'],
            'title' => ['required', 'string'],
            'budget_usd' => ['required', 'numeric', 'min:50.0'] // Must be above $50
        ];
    }
}
