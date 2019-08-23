<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Collection;

class UserRessource extends JsonResource
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
            'type'          => 'User',
            'id'            => (string)$this->id,
			'Name'          => (string)$this->name,
			'Email'         => (string)$this->email,
			'Video Name 1'         => (string)$this->VideoName,
			'Video Name 2'         => (string)$this->VideoName2,
			'Video Name 3'         => (string)$this->VideoName3,
			'Video Name 4'         => (string)$this->VideoName4,
			'Video Name 5'         => (string)$this->VideoName5,
           
        ];
    }
}
