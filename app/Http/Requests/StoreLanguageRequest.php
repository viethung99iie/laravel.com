<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreLanguageRequest extends FormRequest
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
            'name' => 'required|string',
            'canonical' => 'required|string|max:5|unique:languages,canonical',
        ];
    }

     public function messages(): array
    {
        return [
            'required' => ':attribute không được để trống',
            'string' => ':attribute phải là ký tự',
            'unique' => ':attribute đã tồn tại trong hệ thống',
            'max' => ':attribute tối đa :max ký tự',
            'min' => ':attribute tối thiểu :max ký tự',
        ];
    }

    public function attributes(): array
    {
        return [
            'name' => 'Tên ngôn ngữ',
            'canonical'=> 'canonical',
        ];
    }
}
