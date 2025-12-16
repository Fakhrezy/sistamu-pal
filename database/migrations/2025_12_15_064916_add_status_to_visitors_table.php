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
        Schema::table('data_visitors', function (Blueprint $table) {
            $table->enum('status', ['check in', 'check out'])->default('check in')->after('kontak');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('data_visitors', function (Blueprint $table) {
            $table->dropColumn('status');
        });
    }
};
