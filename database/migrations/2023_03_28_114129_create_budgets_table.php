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
        Schema::create('budgets', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('bank_id')->nullable();
            $table->string('type');
            $table->unsignedBigInteger('user_id');
            $table->char('numbers',4)->nullable();
            $table->Double('budget');
            $table->char('last_date',4)->nullable();
            $table->timestamps();

            $table->index('user_id', 'user_budget_idx');
            $table->foreign('user_id', 'user_budget_fk')->on('users')->references('id') ->onUpdate('cascade')
                ->onDelete('cascade');

            $table->index('bank_id', 'bank_idx');
            $table->foreign('bank_id', 'bank_fk')->on('banks')->references('id') ->onUpdate('cascade')
                ->onDelete('cascade');


        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('budgets');
    }
};
