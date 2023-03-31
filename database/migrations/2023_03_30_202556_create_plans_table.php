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

            $table->id();
            $table->text('title');
            $table->unsignedInteger('categories_id');
            $table->timestamp('period_start');
            $table->timestamp('period_finish');
            $table->unsignedInteger('max_price');
            $table->unsignedInteger('user_id');
            $table->timestamps();
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
