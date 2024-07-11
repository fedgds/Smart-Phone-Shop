<?php

namespace App\Http\Requests\Category;

use Illuminate\Foundation\Http\FormRequest;

class StoreCategoryRequest extends FormRequest
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
    public function rules()
    {
        return [
            'name' => 'required|max:255',
            'slug' => 'required|max:255|unique:categories,slug',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Vui lòng nhập tên',
            'name.max' => 'Tên không được đặt quá 255 kí tự',
            'slug.required' => 'Vui lòng nhập slug',
            'slug.unique' => 'Slug đã tồn tại',
            'slug.max' => 'Slug không được đặt quá 255 kí tự',
            'image.required' => 'Vui lòng chọn ảnh',
            'image.image' => 'Tệp tải lên phải là một hình ảnh.',
            'image.mimes' => 'Hình ảnh phải có định dạng: jpeg, png, jpg, gif, svg, webp.',
            'image.max' => 'Hình ảnh không được vượt quá 2048 KB.',
        ];
    }
}
