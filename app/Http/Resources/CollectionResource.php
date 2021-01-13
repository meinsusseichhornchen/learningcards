<?php

namespace App\Http\Resources;

use App\Card;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\CardResource;
use App\Http\Resources\UserResource;

class CollectionResource extends JsonResource
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
            'name' => $this->name,
            'description' => $this->description,
            'author' => new UserResource($this->user),
            'tags' => $this->tags,
            'links' => [
                'edit' => route('edit_collection', $this->id)
            ],
            'cards' => new CardCollection($this->cards),
        ];
    }
}
