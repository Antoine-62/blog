<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequestImp extends FormRequest
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
            'file'=>'required|max:2000'
        ];
    }
	public function messages()
	{
		return [
			'file.required' => 'A file is required',
			'file.max' => 'The size of the file must no exceeds 2000 bytes',
		];
	}
}
