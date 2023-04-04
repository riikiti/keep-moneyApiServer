<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PlanBudgetResource extends JsonResource
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
            'budget_id'=>$this->budget_id,
            'user_id'=>$this->user_id,
            'value'=>$this->value,
            'period_start'=>$this->period_start,
            'period_finish'=>$this->period_finish,
        ];
    }
}
