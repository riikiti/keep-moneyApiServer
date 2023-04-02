<?php

namespace App\Http\Controllers\Api\Budget;

use App\Http\Controllers\Controller;
use App\Models\Budget;


class IndexController extends Controller
{
    public function __invoke()
    {
        $budget = Budget::all();
        dd($budget);

    }
}
