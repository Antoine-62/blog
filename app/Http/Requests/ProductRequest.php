<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
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
                'FirstName'=>'required',
				'LastName'=> 'required',
				'Birth'=>'required',
				'City'=> 'required',
				'Country' => 'required',
				'Mail' => 'required',
				'Phone' => 'required|regex:/[0-9]{11}/',
				'PreferC' => 'required',
				'fileU'=>'max:2000',
        ];
    }
	public function messages()
{
    return [
        'FirstName.required' => 'A FirstName is required',
        'LastName.required'  => 'A LastNamed is required',
		'Birth.required' => 'A BirthDay is required',
        'City.required'  => 'The city is required',
		'Country.required' => 'The country is required',
        'Mail.required'  => 'A Mail is required',
		'Phone.required' => 'A Number Phone is required, and it must be equals to 11 numbers(yes it is a test ok?)',
		'Phone.regex' => 'The Number Phone must be contains 11 numbers(yes, 11 numbers it is a test ok?)',
        'PreferC.required'  => 'Tou need to select one of the fields',
		'fileU.max'  => 'The file you try to upload is too big',
    ];
}
}
