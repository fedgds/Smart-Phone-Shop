<?php

namespace App\Http\Requests\Category;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateCategoryRequest extends FormRequest
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
             'slug' => ['required', 'max:255', Rule::unique('categories')->ignore($this->categoryId)],
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
         ];
     }
}
