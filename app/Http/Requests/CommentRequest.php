<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class CommentRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return (Auth::check());
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'comment' => 'required|string|max:255|min:5'
        ];
    }
    public function messages(): array
    {
        return [
            'comment.required' => 'Yorum alanı boş bırakılamaz!',
            'comment.string' => 'Yorum alanı metin tipinde olmalıdır!',
            'comment.max' => 'Yorum alanı en fazla 255 karakter olabilir!',
            'comment.min' => 'Yorum alanı en az 5 karakter olabilir!'
        ];
    }
}
