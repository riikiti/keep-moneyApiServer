<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class NotificationResource extends JsonResource
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
            'text'=>$this->text,
            'period_finish'=>$this->period_finish,
            'categories_id'=>$this->categories_id,
        ];
    }
}
