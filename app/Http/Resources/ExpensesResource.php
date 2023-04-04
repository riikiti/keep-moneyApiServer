<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ExpensesResource extends JsonResource
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
            'user_id'=>$this->user_id,
            'check_id'=>$this->check_id,
            'shops_id'=>$this->shops_id,
            'categories_id'=>$this->categories_id,
        ];
    }
}
