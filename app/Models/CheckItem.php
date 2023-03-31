<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CheckItem extends Model
{
    use HasFactory;
    protected $table = 'check_items';
    protected $fillable =['name','price'];
}
