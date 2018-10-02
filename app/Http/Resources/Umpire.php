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
            'team_id'   => $this->team_id
        ];
    }

    public function with($request)
    {
        return [
            'status'    => 'success'
        ];
    }
}