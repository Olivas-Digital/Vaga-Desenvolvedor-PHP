<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ClientResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  Request  $request
     * @return array
     */
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'type' => new ClientTypeResource($this->whenLoaded('clientType')),
            'phones' => PhoneResource::collection($this->whenLoaded('phones')),
            'sellers' => SellerResource::collection($this->whenLoaded('sellers')),
            '_links' => [
                [
                    'href' => route('clients.show', $this),
                    'rel' => 'show',
                    'type' => 'GET'
                ],
                [
                    'href' => route('clients.update', $this),
                    'rel' => 'update',
                    'type' => 'PUT'
                ],
                [
                    'href' => route('clients.destroy', $this),
                    'rel' => 'destroy',
                    'type' => 'DELETE'
                ],
            ],
        ];
    }
}
