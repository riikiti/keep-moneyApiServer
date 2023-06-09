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


        Schema::create('items', function (Blueprint $table) {

            $table->bigIncrements('id');
            $table->string('name');
            $table->unsignedDouble('price');
            $table->unsignedSmallInteger('count');
            $table->unsignedBigInteger('check_id');
            $table->timestamps();


            $table->index('check_id', 'check_item_idx');
            $table->foreign('check_id', 'check_item_fk')->on('checks')->references('id') ->onUpdate('cascade')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('check_items');
    }
};
