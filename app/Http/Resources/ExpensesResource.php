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
            'checks'=>new CheckResource($this->check),
            'shop'=>new ShopsResource($this->shops),
            'category'=>new CategoriesResource($this->categories),
            'budget'=>new BudgetResource($this->budget),
            'date'=>$this->date,
        ];
    }
}
