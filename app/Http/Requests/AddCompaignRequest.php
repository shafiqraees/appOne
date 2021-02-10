<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AddCompaignRequest extends FormRequest
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
            'Name' => 'required',
            'AddDate' => 'required',
            'Location' => 'required',
            'latitude' => 'required',
            'longitude' => 'required',
            'Fund_to' => 'required',
        ];
    }
}
