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


        Schema::create('plans', function (Blueprint $table) {

            $table->bigIncrements('id');
            $table->text('title');
            $table->unsignedBigInteger('categories_id');
            $table->timestamp('period_start');
            $table->timestamp('period_finish');
            $table->unsignedBigInteger('max_price');
            $table->unsignedBigInteger('user_id');
            $table->timestamps();

            $table->index('categories_id', 'categories_idx');

            $table->foreign('categories_id', 'categories_fk')->on('categories')->references('id') ->onUpdate('cascade')
                ->onDelete('cascade');


            $table->index('user_id', 'user_plan_idx');
            $table->foreign('user_id', 'user_plan_fk')->on('users')->references('id') ->onUpdate('cascade')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('plans');
    }
};
