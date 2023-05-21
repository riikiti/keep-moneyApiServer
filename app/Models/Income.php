<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;


class Income extends Model
{
    use HasFactory;
    protected $table = 'incomes';
    //protected $fillable =['title','categories_id','price','date','user_id'];
    protected $guarded=[];
    public function categories(): BelongsTo
    {
        return $this->belongsTo(IncomeCategories::class);
    }
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
    public function budget(): BelongsTo
    {
        return $this->belongsTo(Budget::class);
    }

}
