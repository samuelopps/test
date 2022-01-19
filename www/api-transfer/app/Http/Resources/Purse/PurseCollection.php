<?php

namespace App\Http\Resources\Purse;

use Illuminate\Http\Resources\Json\ResourceCollection;

/**
 * Class PurseCollection
 * @package App\Http\Resources
 */
class PurseCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'data' => $this->collection,
        ];
    }
}
