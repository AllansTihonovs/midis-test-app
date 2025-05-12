<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class AdminFormRequest extends FormRequest
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
        $rules = [
            'name'  => 'required|max:255',
            'email' => 'required|email|max:255|unique:users,email',
        ];

        if ($this->isMethod('post')) {
            $rules['password'] = 'required|min:7|max:255';
        }

        if ($this->isMethod('put') || $this->isMethod('patch')) {
            $rules['password'] = 'nullable|min:7|max:255';
            $rules['email'] = 'required|email|max:255|unique:users,email,' . $this->route('administrator')->id;
        }

        return $rules;
    }
}
