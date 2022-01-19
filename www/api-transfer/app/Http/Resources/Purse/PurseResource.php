<?php

namespace App\Http\Resources\Purse;

use App\Http\Resources\User\UserResource;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Class PurseResource
 * @package App\Http\Resources
 */
class PurseResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'balance' => $this->balance,
            'status' => $this->status,
            'user' => new UserResource($this->user)
        ];
    }
}
