<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class CardImageResource extends JsonResource
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
            'url' => $this->url,
            'type' => Storage::mimeType('public/'.$this->url),
            'path' => asset('/storage/' . $this->url),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
