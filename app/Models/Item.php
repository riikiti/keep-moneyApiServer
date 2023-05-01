<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory;
    protected $table = 'items';
    //protected $fillable =['name','price','count','check_id'];
    protected $guarded=[];
    public function check()
    {
        return $this->belongsTo(Check::class);
    }
}
