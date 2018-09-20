<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Club extends JsonResource
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
            'id'                => $this->id,
            'name'              => $this->name,
            'primary_color'     => $this->primary_colour,
            'secondary_colour'  => $this->secondary_colour,
            'tertiary_colour'   => $this->tertiary_colour,
            'logo_url'          => $this->logo_url,
            'narrative'         => $this->narrative
        ];
    }

    public function with($request)
    {
        return [
            'status'    => 'success'
        ];
    }

}
