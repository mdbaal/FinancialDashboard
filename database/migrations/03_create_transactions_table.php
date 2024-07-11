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
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->string('account');
            $table->string('receiver');
            $table->string('description');
            $table->decimal('amount',10,2);
            $table->decimal('amount_after',10,2);
            $table->string('category')->default('None');
            $table->dateTime('date',);


            $table->foreign('account')->references('name')->on('accounts');
            $table->foreign('category')->references('name')->on('categories');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
