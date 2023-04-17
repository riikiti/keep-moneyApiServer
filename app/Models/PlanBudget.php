<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PlanBudget extends Model
{
    use HasFactory;
    protected $table = 'plan_budgets';
    //protected $fillable =['value','period_start','period_finish','user_id'];
    protected $guarded=[];
}
