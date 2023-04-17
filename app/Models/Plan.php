<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Plan extends Model
{
    use HasFactory;

    protected $table = 'plans';
    //protected $fillable =['title','categories','period_start','period_finish','max_price','user_id'];
    protected $guarded = [];

    public function categories(): BelongsTo
    {
        return $this->belongsTo(Categories::class);
    }
}
