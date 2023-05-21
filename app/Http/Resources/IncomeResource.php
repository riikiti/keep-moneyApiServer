<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class IncomeResource extends JsonResource
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
            'category'=> new IncomeCategoriesResource($this->categories),
            'price'=>$this->price,
            'date'=>$this->date,
          //  'users'=> new UsersResource($this->user),
            'budget'=>new BudgetResource($this->budget),
            'user_id'=>$this->user_id
        ];
    }
}
