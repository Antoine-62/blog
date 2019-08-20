<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest2 extends FormRequest
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
            'Name'=>'required',
			'Email'=> 'required',
        ];
    }
	
	public function messages()
	{
		return [
			'Name.required' => 'The name of the User is required',
			'Email.required' => 'The email of the user is required',
		];
	}
}
