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
        Schema::create('cart_items', function (Blueprint $table) {
            $table->id();
            $table->string('users_id'); // Cambiamos el tipo a string para referenciar google_id
            $table->foreign('users_id')->references('google_id')->on('users')->onDelete('cascade');
            $table->foreignId('products_id')->constrained()->onDelete('cascade');
            $table->integer('quantity')->default(1);
            $table->boolean('status')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cart_items');
    }
};
