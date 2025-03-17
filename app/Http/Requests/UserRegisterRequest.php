<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRegisterRequest extends FormRequest
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
            'name' => 'required',
            'surname' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6|confirmed'
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'İsim alanı boş bırakılamaz.',
            'surname.required' => 'Soyad alanı boş bırakılamaz.',
            'email.required' => 'Lütfen bir email adresi girin.',
            'email.email' => 'Geçerli bir email adresi girin.',
            'email.unique' => 'Bu email adresi zaten kullanılıyor.',
            'password.required' => 'Şifre alanı boş bırakılamaz.',
            'password.min' => 'Şifre en az 6 karakter olmalıdır.',
            'password.confirmed' => 'Şifre ve şifre tekrarınız uyuşmuyor.'
        ];
    }
}
