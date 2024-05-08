<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreUserRequest extends FormRequest
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
            'email' => 'required|email|string|unique:users|max:191',
            'name' => 'required|string',
            'user_catalogue_id' => 'required|integer|gt:0',
            'password' => 'required|string|min:6',
            're_password' => 'required|string|same:password',
        ];
    }

     public function messages(): array
    {
        return [
            'required' => ':attribute không được để trống',
            'string' => ':attribute phải là ký tự',
            'max' => ':attribute tối đa :max ký tự',
            'min' => ':attribute tối thiểu :max ký tự',
            'email.email' => ':attribute chưa đúng định dạng',
            'email.unique' => ':attribute đã tồn tại, vui lòng sử dụng email khác',
            'user_catalogue_id.integer' => ':attribute chưa được chọn',
            'user_catalogue_id.gt' => ':attribute chưa được chọn',
            're_password.same' => ':attribute không chính xác',

            'min' => ':attribute có ít nhất :min ký tự',
        ];
    }

    public function attributes(): array
    {
        return [
            'email' => 'Email',
            'name' => 'Tên người dùng',
            'user_catalogue_id' => 'Nhóm người dùng',
            'password' => 'Mật khẩu',
            're_password' => ' Xác nhận mật khẩu',
        ];
    }
}
