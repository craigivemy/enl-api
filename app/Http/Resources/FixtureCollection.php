<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\ResourceCollection;

class FixtureCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'data'  => $this->collection->groupBy(function($item, $key) {
                return Carbon::parse($item->match_date)->format('d-m-Y');
            }),
            'links' => [
                'self'  => 'link-value'
            ]
        ];
    }
}
