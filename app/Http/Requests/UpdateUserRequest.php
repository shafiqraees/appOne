<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required',
            'profile_photo_path' => 'nullable',
            'gender' => 'required',
            'date_of_birth' => 'required',
            'device_type' => 'required',
            'device_token' => 'required',
            'country_id' => 'required',
            'city_id' => 'required',
            'user_type' => 'nullable',
            'phone' => 'nullable',
            'address' => 'nullable',
            'about' => 'nullable',
        ];
    }
}
