<?php

namespace App\Http\Resources\Transfer;

use App\Http\Resources\Purse\PurseResource;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Class TransferResource
 * @package App\Http\Resources
 */
class TransferResource extends JsonResource
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
            'amount' => $this->amount,
            'status' => $this->status,
            'paying_purse' => new PurseResource($this->payingPurse),
            'receiver_purse' => new PurseResource($this->receiverPurse)
        ];
    }
}
