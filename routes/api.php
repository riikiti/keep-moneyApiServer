<?php
namespace App\Http\Controllers\Api;

use App\Models\CheckItem;
use App\Models\Expenses;
use App\Models\PlanBudget;
use Illuminate\Http\Request;
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



