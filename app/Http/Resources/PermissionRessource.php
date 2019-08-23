<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PermissionRessource extends JsonResource
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
            'type'          => 'Permission',
            'id'            => (string)$this->id,
			'basic_page_id'          => (string)$this->basic_page_id,
			'user_id'         => (string)$this->user_id,
			];
    }
}
