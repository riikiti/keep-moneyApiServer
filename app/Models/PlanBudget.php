<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PlanBudget extends Model
{
    use HasFactory;
    protected $table = 'plan_budgets';
    //protected $fillable =['value','period_start','period_finish','user_id'];
    protected $guarded=[];

    public function budget(): BelongsTo
    {
        return $this->belongsTo(Budget::class);
    }

}
