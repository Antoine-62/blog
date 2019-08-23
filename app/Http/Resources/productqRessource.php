<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class productqRessource extends JsonResource
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
            'type'          => 'ProductQ',
            'id'            => (string)$this->id,
			'Name'          => (string)$this->Name,
			'Price'         => (string)$this->Price,
           
        ];
    }
}
