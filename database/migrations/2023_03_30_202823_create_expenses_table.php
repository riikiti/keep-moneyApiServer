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


        Schema::create('expenses', function (Blueprint $table) {

            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('check_id')->nullable();
            $table->unsignedBigInteger('categories_id');
            $table->unsignedBigInteger('budget_id')->nullable();
            $table->timestamp('date');
            $table->timestamps();

            $table->index('categories_id', 'categories_check_idx');
            $table->foreign('categories_id', 'categories_check_fk')->on('categories')->references('id') ->onUpdate('cascade')
                ->onDelete('cascade');


            $table->index('check_id', 'check_idx');
            $table->foreign('check_id', 'check_fk')->on('checks')->references('id') ->onUpdate('cascade')
                ->onDelete('cascade');

            $table->index('user_id', 'user_expenses_idx');
            $table->foreign('user_id', 'user_expenses_fk')->on('users')->references('id') ->onUpdate('cascade')
                ->onDelete('cascade');

            $table->index('budget_id', 'budget_expenses_idx');
            $table->foreign('budget_id', 'budget_expenses_fk')->on('budgets')->references('id') ->onUpdate('cascade')
                ->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('expenses');
    }
};
