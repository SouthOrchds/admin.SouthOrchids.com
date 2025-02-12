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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->dateTime('order_date');
            $table->unsignedInteger('user_id');
            $table->unsignedInteger('transaction_id')->nullable();
            $table->json('total_count');
            $table->unsignedInteger('total_amount');
            $table->string('payment_status');
            $table->string('delivery_status')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
