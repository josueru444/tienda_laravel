<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('users_id'); // Cambiamos el tipo a string para referenciar google_id
            $table->foreign('users_id')->references('google_id')->on('users')->onDelete('cascade');
            $table->string('shipping_address');
            $table->string('status')->default('pending'); // Estado inicial del pedido
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
}

