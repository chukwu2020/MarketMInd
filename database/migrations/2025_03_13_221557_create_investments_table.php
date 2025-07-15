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
        Schema::create('investments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('plan_id')->constrained()->onDelete('cascade');
            $table->integer('amount_invested');
            $table->float('roi', 5, 2)->nullable(); // Interest Rate
            $table->float('profit')->nullable();
            $table->float('total_profit')->nullable();
            $table->date('start_date');
            $table->date('end_date');
            $table->boolean('withdrawn')->default(0);
            $table->boolean('due')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('investments');
    }
};
