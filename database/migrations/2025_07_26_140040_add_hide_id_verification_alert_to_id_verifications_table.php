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
     Schema::table('id_verifications', function (Blueprint $table) {
            if (!Schema::hasColumn('id_verifications', 'hide_id_verification_alert')) {
                $table->boolean('hide_id_verification_alert')->default(false)->after('status');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('id_verifications', function (Blueprint $table) {
            if (Schema::hasColumn('id_verifications', 'hide_id_verification_alert')) {
                $table->dropColumn('hide_id_verification_alert');
            }
        });
    }
};
