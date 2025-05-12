<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Http;

class StoreMessageRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'name'    => 'required|max:255',
            'email'   => 'required|email|max:255',
            'message' => 'required|max:1000',
            'image'   => 'nullable|image|mimes:jpg,jpeg,png|max:4096',
            'captcha_token' => 'required',
        ];
    }

    /**
     * @param $validator
     * @throws \Illuminate\Http\Client\ConnectionException
     */
    public function withValidator($validator) :void
    {
        $validator->after(function ($validator) {
            if (!$this->validateCaptcha()) {
                $validator->errors()->add('captcha_token', 'CAPTCHA validation failed.');
            }
        });
    }

    /**
     * Validate score based token
     *
     * @return bool
     * @throws \Illuminate\Http\Client\ConnectionException
     */
    protected function validateCaptcha(): bool
    {
        $response = Http::asForm()->post('https://www.google.com/recaptcha/api/siteverify', [
            'secret' => config('services.google_recaptcha.secret_key'),
            'response' => $this->input('captcha_token'),
            'remoteip' => $this->ip(),
        ]);
        $json = $response->json();

        return $json['success'] === true
            && $json['action'] === 'submit_message'
            && $json['score'] >= 0.5;
    }
}
