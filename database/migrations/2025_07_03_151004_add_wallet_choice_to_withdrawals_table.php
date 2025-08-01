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
     Schema::table('withdrawals', function (Blueprint $table) {
    $table->string('wallet_choice')->nullable()->after('amount');
});

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
   Schema::table('withdrawals', function (Blueprint $table) {
    $table->dropColumn('wallet_choice');
});

    }
};
