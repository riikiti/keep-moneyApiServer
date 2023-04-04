<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\v1\BudgetController;
use App\Http\Controllers\Api\v1\CategoriesController;
use App\Http\Controllers\Api\v1\CheckController;
use App\Http\Controllers\Api\v1\CheckItemController;
use App\Http\Controllers\Api\v1\ExpensesController;
use App\Http\Controllers\Api\v1\IncomeCategoriesController;
use App\Http\Controllers\Api\v1\IncomeController;
use App\Http\Controllers\Api\v1\PlanBudgetController;
use App\Http\Controllers\Api\v1\PlanController;
use App\Http\Controllers\Api\v1\ShopsController;
use Illuminate\Support\Facades\Route;


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/



Route::apiResources([
    'budget' => BudgetController::class,
    'categories' =>CategoriesController::class,
    'check' =>CheckController::class,
    'check-item' =>CheckItemController::class,
    'expenses' =>ExpensesController::class,
    'income' => IncomeController::class,
    'income-categories' =>IncomeCategoriesController::class,
    'plan-budget' =>PlanBudgetController::class,
    'plan' =>PlanController::class,
    'shops' =>ShopsController::class,
]);



