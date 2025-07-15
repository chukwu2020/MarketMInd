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
    Schema::table('users', function (Blueprint $table) {
        $table->string('email_verification_otp')->nullable()->after('email_verified_at');
        $table->string('email_verification_token')->nullable()->after('email_verification_otp');
        $table->unsignedBigInteger('referred_by')->nullable()->after('email_verification_token');
        $table->string('referral_link')->nullable()->after('referred_by');
    });
}

    /**
     * Reverse the migrations.
     */
  public function down(): void
{
    Schema::table('users', function (Blueprint $table) {
        $table->dropColumn([
            'email_verification_otp',
            'email_verification_token',
            'referred_by',
            'referral_link'
        ]);
    });
}
};
