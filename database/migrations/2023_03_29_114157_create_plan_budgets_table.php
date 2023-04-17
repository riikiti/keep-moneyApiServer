<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('plan_budgets', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('budget_id');
            $table->unsignedDouble('budget_on_start');
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('value');
            $table->timestamp('period_start');
            $table->timestamp('period_finish');
            $table->timestamps();


            $table->index('budget_id', 'budget_idx');
            $table->foreign('budget_id', 'budget_fk')->on('budgets')->references('id') ->onUpdate('cascade')
                ->onDelete('cascade');

            $table->index('user_id', 'user_budget_plan_idx');
            $table->foreign('user_id', 'user_budget_plan_fk')->on('users')->references('id') ->onUpdate('cascade')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('plan_budgets');
    }
};
