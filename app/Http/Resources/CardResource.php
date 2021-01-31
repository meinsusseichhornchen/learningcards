<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CardResource extends JsonResource
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
            'id' => $this->id,
            'answers' => $this->answers,
            'images' => new CardImageCollection($this->images),
            'cardable_type' => $this->cardable_type,
            'links' => [
                'edit' => route('edit_card', $this->id)
            ]
        ];
    }
}
