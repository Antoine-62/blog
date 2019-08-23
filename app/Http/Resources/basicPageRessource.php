<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class basicPageRessource extends JsonResource
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
            'type'          => 'Basic Page',
            'id'            => (string)$this->id,
			'Title'          => (string)$this->Title,
			'Content'         => (string)$this->Content,
			'NamePage'         => (string)$this->NamePage,
			];
    }
}
