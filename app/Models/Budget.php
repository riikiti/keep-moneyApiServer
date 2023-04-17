<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Budget extends Model
{
    use HasFactory;
    protected $table = 'budgets';
    protected $fillable =['bank_id','type','numbers','budget','last_date','user_id'];

    public function bank(): BelongsTo
    {
        return $this->belongsTo(Bank::class);
    }
}
