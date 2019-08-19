<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest2 extends FormRequest
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
            'Title' => 'required',
			'FirstName'=>'required',
			'LastName'=> 'required',
			'Birth'=>'required',
			'City'=> 'required',
			'Country' => 'required',
			'Mail' => 'required',
			'Phone' => 'required|regex:/[0-9]{11}/',
			'PreferC' => 'required',
			'fileU'=>'required|image|mimes:jpeg,png,jpg,gif|max:2000'
        ];
    }
	
		public function messages()
	{
		return [
			'Title.required' => 'A Title is required',
			'FirstName.required' => 'A FirstName is required',
			'LastName.required'  => 'A LastNamed is required',
			'Birth.required' => 'A BirthDay is required',
			'City.required'  => 'The city is required',
			'Country.required' => 'The country is required',
			'Mail.required'  => 'A Mail is required',
			'Phone.required' => 'A Number Phone is required, and it must be equals to 11 numbers(yes it is a test ok?)',
			'Phone.regex' => 'The Number Phone must contains 11 numbers(yes, 11 numbers it is a test ok?)',
			'PreferC.required'  => 'You need to select one of the fields',
			'fileU.required' => 'A image of the product is required',
			'fileU.image'  => 'The file must be an image',
			'fileU.mimes' => 'The type of the file must be one the following : jpeg, png, jpg and gif',
			'fileU.max' => 'The size of the file must no exceeds 2000 bytes',
		];
	}
}
