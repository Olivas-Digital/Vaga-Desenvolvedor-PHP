<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SellerResource extends JsonResource
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
            'clients' => ClientResource::collection($this->whenLoaded('clients')),
            '_links' => [
                [
                    'href' => route('sellers.show', $this),
                    'rel' => 'show',
                    'type' => 'GET'
                ],
                [
                    'href' => route('sellers.update', $this),
                    'rel' => 'update',
                    'type' => 'PUT'
                ],
                [
                    'href' => route('sellers.destroy', $this),
                    'rel' => 'destroy',
                    'type' => 'DELETE'
                ],
            ],
        ];
    }
}
