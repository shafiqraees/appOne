<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateAccountRequest extends FormRequest
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
     * @return array
     */
    public function rules()
    {
        return [
            'user_id' => 'required',
            'country_id' => 'required',
            'city_id' => 'required',
            'profile_name' => 'required',
            'profile_email' => 'required|email',
            'profile_image' => 'nullable',
            'profile_videos' => 'nullable',
            'profile_phone' => 'nullable',
            'profile_address' => 'nullable',
            'profile_website' => 'nullable',
            'profile_about' => 'nullable',
            'profile_banner' => 'nullable',
            'profile_type' => 'required',
            'profile_status' => 'required',
            'interest' => 'required',
        ];
    }
}
