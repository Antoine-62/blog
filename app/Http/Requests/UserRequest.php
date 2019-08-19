<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
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
            'name' => 'required|min:3|max:50',
			'email' => 'required',
			'password' => 'min:6|required_with:password_confirmation|same:password_confirmation',
			'password_confirmation' => 'min:6',
			'type' => 'required'
        ];
    }
	
	public function messages()
	{
		return [
			'name.required' => 'The name of the User is required',
			'name.min' => 'The name must be more than 3 letters',
			'name.max' => 'The name must not be exceeds 50 letters',
			'password.min'  => 'The password must be at least 6characters.',
			'password.required_with'  => 'The password and password confirmation must be filled',
			'password.same'  => 'The password and password confirmation are differents',
			'password_confirmation.min'  => 'The password confirmation must be at least 6characters',
			'type.required' => 'The type is required',
		];
	}
}
