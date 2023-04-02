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
            $table->id();
            //'bank','type','number','budget','last_date'
            $table->string('bank');
            $table->string('type');
            $table->unsignedBigInteger('user_id');
            $table->char('numbers',4);
            $table->unsignedBigInteger('budget');
            $table->char('last_date',4);
            $table->timestamps();
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
