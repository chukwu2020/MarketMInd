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
        Schema::create('withdrawal_cards', function (Blueprint $table) {
         $table->id();
        $table->foreignId('user_id')->constrained()->onDelete('cascade');
        $table->string('card_number');
        $table->string('pin');
        $table->string('name_on_card');
        $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('withdrawal_cards');
    }
};
