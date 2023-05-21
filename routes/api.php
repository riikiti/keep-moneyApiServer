<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\v1\BankController;
use App\Http\Controllers\Api\v1\BudgetController;
use App\Http\Controllers\Api\v1\CategoriesController;
use App\Http\Controllers\Api\v1\CheckController;
use App\Http\Controllers\Api\v1\IncreaseBudgetController;
use App\Http\Controllers\Api\v1\ItemController;
use App\Http\Controllers\Api\v1\ExpensesController;
use App\Http\Controllers\Api\v1\IncomeCategoriesController;
use App\Http\Controllers\Api\v1\IncomeController;
use App\Http\Controllers\Api\v1\NotificationController;
use App\Http\Controllers\Api\v1\PlanBudgetController;
use App\Http\Controllers\Api\v1\PlanController;
use App\Http\Controllers\Api\v1\ReduseBudgetController;
use App\Http\Controllers\Api\v1\ShopsController;
use App\Http\Controllers\Api\v1\UsersController;
use App\Http\Requests\UsersStoreRequest;
use Illuminate\Support\Facades\Route;

Route::group(['middleware' => 'auth:sanctum'], function () {

});

Route::apiResources([
    'budget' => BudgetController::class,
    'categories' => CategoriesController::class,
    'check' => CheckController::class,
    'item' => ItemController::class,
    'expenses' => ExpensesController::class,
    'income' => IncomeController::class,
    'income-categories' => IncomeCategoriesController::class,
    'plan-budget' => PlanBudgetController::class,
    'plan' => PlanController::class,
    'shops' => ShopsController::class,
    'bank' => BankController::class,
    'users' => UsersController::class,
]);

Route::put('/reduse-budget/{id}', [ReduseBudgetController::class, 'update']);
Route::put('/increase-budget/{id}', [IncreaseBudgetController::class, 'update']);





