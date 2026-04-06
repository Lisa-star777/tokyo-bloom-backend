<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained();
            $table->json('items');
            $table->decimal('subtotal', 10, 2);
            $table->decimal('delivery_cost', 10, 2)->default(300);
            $table->decimal('certificate_discount', 10, 2)->default(0);
            $table->decimal('bonuses_used', 10, 2)->default(0);
            $table->decimal('total', 10, 2);
            $table->integer('bonuses_earned')->default(0);
            $table->json('certificate_used')->nullable();
            $table->json('delivery_details')->nullable();
            $table->string('status')->default('new');
            $table->string('status_text')->default('Новый');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};