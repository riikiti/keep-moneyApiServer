<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IncomeCategories extends Model
{
    use HasFactory;
    protected $table = 'income_categories';
    protected $fillable =['name','user_id'];

}
