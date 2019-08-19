<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ImRequest extends FormRequest
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
            'mydata'=>'required',
        ];
    }
	
		public function messages()
	{
		return [
			'mydata.required' => 'Soory, we do not have your image',
		];
	}
}
