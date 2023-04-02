<?php

namespace App\Http\Controllers\Api\Categories;

use App\Http\Controllers\Controller;
use App\Models\Categories;


class IndexController extends Controller
{
    public function __invoke()
    {
        $budget = Categories::all();
        dd($budget);

    }
}
