<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('incomes', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->text('title');
            $table->unsignedBigInteger('categories_id');
            $table->unsignedDouble('price');
            $table->timestamp('date');
            $table->unsignedBigInteger('user_id');
            $table->timestamps();

            $table->index('categories_id', 'income_categories_idx');

            $table->foreign('categories_id', 'income_categories_fk')->on('income_categories')->references('id')->onUpdate('cascade')
                ->onDelete('cascade');

            $table->index('user_id', 'user_income_idx');
            $table->foreign('user_id', 'user_income_fk')->on('users')->references('id') ->onUpdate('cascade')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('incomes');
    }
};
