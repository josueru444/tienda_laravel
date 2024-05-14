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
        Schema::create('pay_order', function (Blueprint $table) {
            $table->id();
            $table->float('total');
            $table->longText('file')->nullable();
            $table->longText('observations')->nullable();
            $table->boolean('status')->default(1);
            $table->text('paypalID')->nullable();
            $table->unsignedBigInteger('orders_id');
            $table->foreign('orders_id')->references('id')->on('orders')->onDelete('cascade');
            $table->string('user_id');
            $table->foreign('user_id')->references('google_id')->on('users')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pay_order');
    }
};
