<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CheckoutRequest extends FormRequest
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
            'full_name' => 'required',
            'phone_number' => ['required', 'regex:/^(0|\+84)\d{9,10}$/'],
            'city' => 'required',
            'district' => 'required',
            'address' => 'required',
        ];
    }

    public function messages(): array
    {
        return [
            'full_name.required' => 'Vui lòng nhập họ và tên',
            'phone_number.required' => 'Vui lòng nhập số điện thoại',
            'phone_number.regex' => 'Vui lòng nhập số điện thoại đúng định dạng',
            'city.required' => 'Vui lòng nhập thành phố',
            'district.required' => 'Vui lòng nhập quận huyện',
            'address.required' => 'Vui lòng nhập quận huyện',
        ];
    }
}
