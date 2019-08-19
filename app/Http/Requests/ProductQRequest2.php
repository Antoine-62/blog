<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductQRequest2 extends FormRequest
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
        'Category'=> 'required',
		'Price'=>'required',
        'ProductS'=> 'required',
		'photos.*' =>'image|mimes:jpeg,png,jpg,gif|max:2000'
        ];
    }
	
		public function messages()
	{
		return [
			'Name.required' => 'The name of the product is required',
			'Category.required'  => 'The category of the product is required',
			'Price.required' => 'A price is required',
			'ProductS.required'  => 'The state of the product is required',
			'photos.image'  => 'The file must be an image',
			'photos.mimes' => 'The type of the file must be one the following : jpeg, png, jpg and gif',
			'photos.max' => 'The size of the file must no exceeds 2000 bytes',
		];
	}
}
