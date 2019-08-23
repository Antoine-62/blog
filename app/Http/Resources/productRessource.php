<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class productRessource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
         return [
            'type'          => 'Product',
            'id'            => (string)$this->id,
			'Title'          => (string)$this->Title,
			'FirstName'         => (string)$this->FirstName,
			'LastName'         => (string)$this->LastName,
			'birth'         => (string)$this->birth,
			'City'         => (string)$this->City,
			'Country'         => (string)$this->Country,
			'Mail'         => (string)$this->Mail,
			'Phone'         => (string)$this->Phone,
			'Prefer to be contacted by'         => (string)$this->PreferC,
			'FileName'         => (string)$this->filename,
			'User Id'         => (string)$this->Uid,
           
        ];
    }
}
