<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BudgetResource extends JsonResource
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
          'bank'=>new BankResource( $this->bank),
          'type'=>$this->type,
          'user_id'=>$this->user_id,
          'numbers'=>$this->numbers,
          'budget'=>$this->budget,
          'last_date'=>$this->last_date
      ];
    }
}
