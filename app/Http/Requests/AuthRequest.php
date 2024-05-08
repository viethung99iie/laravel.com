<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AuthRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'email' => 'required|email',
            'password' => 'required|min:6',
        ];
    }

     public function messages(): array
    {
        return [
            'required' => ':attribute không được để trống',
            'email.email' => ':attribute chưa đúng định dạng',
            'min' => ':attribute có ít nhất :min ký tự',
        ];
    }

    public function attributes(): array
    {
        return [
            'email' => 'Email',
            'password' => 'Mật khẩu',
        ];
    }
}