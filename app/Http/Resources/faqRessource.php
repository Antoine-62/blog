<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class faqRessource extends JsonResource
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
            'type'          => 'Faq',
            'id'            => (string)$this->id,
			'Question'          => (string)$this->Question,
			'Answer'         => (string)$this->Answer,
			'Status'         => (string)$this->Status,           
        ];
    }
}
