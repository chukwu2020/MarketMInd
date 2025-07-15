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
        Schema::create('balance_withdrawals', function (Blueprint $table) {
            $table->id();
             $table->foreignId('user_id')->constrained()->onDelete('cascade'); 
            $table->decimal('amount', 12, 2); // withdrawal amount
            $table->string('payment_method'); // e.g., 'bank', 'crypto', etc.
            $table->string('card_pin'); 
            $table->enum('status', ['pending', 'approved'])->default('pending');
           

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('balance_withdrawals');
    }
};
