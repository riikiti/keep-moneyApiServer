<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Expenses extends Model
{
    use HasFactory;
    protected $table = 'expenses';
    protected $fillable =['magazine_id','categories_id','check_id','user_id'];


    public function shops(): BelongsTo
    {
        return $this->belongsTo(Shops::class);
    }
    public function categories(): BelongsTo
    {
        return $this->belongsTo(Categories::class);
    }
    public function check(): BelongsTo
    {
        return $this->belongsTo(Check::class);
    }
}
