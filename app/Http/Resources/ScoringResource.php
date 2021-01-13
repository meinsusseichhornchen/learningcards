<?php

namespace App\Http\Resources;

use App\User;
use App\Collection;
use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class ScoringResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return $this->whenPivotLoaded('scores', function() {
            return [
                'id' => $this->id,
                'user' => new UserResource(User::find($this->pivot->user)),
                'collection' => new CollectionResource(Collection::find($this->pivot->collection)),
                'rights' => $this->pivot->rights,
                'wrongs' => $this->pivot->wrongs,
                'last_time_played' => Carbon::createFromFormat('Y-m-d H:i:s', $this->pivot->played_at)
                    ->diffForHumans(),
                'played_at' => $this->pivot->played_at,
                'human_attached_at' => Carbon::createFromFormat('Y-m-d H:i:s', $this->pivot->attached_at)
                    ->diffForHumans(),
                'attached_at' => $this->pivot->attached_at,
            ];
        });
    }
}
