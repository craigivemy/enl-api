<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Umpire extends JsonResource
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
            'id'        => $this->id,
            'forename'  => $this->forename,
            'surname'   => $this->surname,
            'about'     => $this->about,
            'email'     => $this->email,
            'phone'     => $this->phone,
            'teamId'   => $this->team_id
        ];
    }
}
