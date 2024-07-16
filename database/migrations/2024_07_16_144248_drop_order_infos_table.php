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
        Schema::dropIfExists('order_infos');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::create('order_infos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained('orders')->cascadeOnDelete();
            $table->string('full_name');
            $table->string('phone_number');
            $table->string('city');
            $table->string('district');
            $table->string('address');
            $table->timestamps();
        });
    }
};
