<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePostRequest extends FormRequest
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
            'canonical' => 'required|unique:routers,canonical,'
            . $this->id . ',module_id',
        ];
    }

    public function messages(): array
    {
        return [
            'required' => ':attribute không được để trống',
            'string' => ':attribute phải là ký tự',
            'unique' => ':attribute đã tồn tại, hãy thử lựa chọn khác',
        ];
    }

    public function attributes(): array
    {
        return [
            'name' => 'Tên nhóm thành viên',
            'parent_id' => 'Danh mục bài viết',
            'canonical' => 'Canonical',
        ];
    }
}
