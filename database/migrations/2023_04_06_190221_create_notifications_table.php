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
        Schema::create('notifications', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->text('text');
            $table->timestamp('period_finish');
            $table->unsignedBigInteger('categories_id')->nullable();
            $table->timestamps();


            $table->index('user_id', 'user_notifications_idx');
            $table->foreign('user_id', 'user_notifications_fk')->on('users')->references('id') ->onUpdate('cascade')
                ->onDelete('cascade');

            $table->index('categories_id', 'categories_notifications_idx');
            $table->foreign('categories_id', 'categories_notifications_fk')->on('categories')->references('id') ->onUpdate('cascade')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notifications');
    }
};
