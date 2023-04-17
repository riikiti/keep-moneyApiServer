<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PlanResource extends JsonResource
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
            'category'=>new CategoriesResource($this->categories),
            'period_start'=>$this->period_start,
            'period_finish'=>$this->period_finish,
            'max_price'=>$this->max_price,
            'user_id'=>$this->user_id,
        ];
    }
}
