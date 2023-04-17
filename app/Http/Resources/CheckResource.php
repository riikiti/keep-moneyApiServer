<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CheckResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return  [
            'id'=>$this->id,
            'title'=>$this->title,
            'total_price'=>$this->total_price,
            'date'=>$this->date,
            'items' => ItemResource::collection($this->item),
        ];
    }
}
