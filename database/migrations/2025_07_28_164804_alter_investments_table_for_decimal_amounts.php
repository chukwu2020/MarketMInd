<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::table('investments', function (Blueprint $table) {
        $table->decimal('amount_invested', 15, 2)->change();
        $table->decimal('profit', 15, 2)->nullable()->change();
        $table->decimal('total_profit', 15, 2)->nullable()->change();
    });
}

public function down()
{
    Schema::table('investments', function (Blueprint $table) {
        $table->integer('amount_invested')->change();
        $table->float('profit')->nullable()->change();
        $table->float('total_profit')->nullable()->change();
    });
}

};
