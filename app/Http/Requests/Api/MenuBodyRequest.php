<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;

class MenuBodyRequest extends FormRequest
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
            'items' => [ 'required' ],
            'model_name' => [ 'required' ],
            'model_color' => [ 'required' ],
            'background_url' => [ 'required' ],
            'background_opacity' => [ 'required' ],
        ];
    }
}
