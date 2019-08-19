<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AdminRequest2 extends FormRequest
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
		'fileBI'=>'required|image|mimes:jpeg,png,jpg,gif|max:2000'
        ];
    }
	
	public function messages()
	{
		return [
			'Name.required' => 'The title of the content is required',
			'fileBI.required' => 'The content is required',
			'fileBI.mimes' => 'The type of the file must be one of the following : jpeg, png, jpg and gif',
			'fileBI.image' => 'The file must be an image',
		];
	}
}
