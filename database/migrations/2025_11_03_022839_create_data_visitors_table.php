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
        Schema::create('data_visitors', function (Blueprint $table) {
            $table->id();
            $table->date('tanggal');
            $table->time('jam');
            $table->string('nama');
            $table->enum('kategori', ['pelanggan', 'tamu']);
            $table->text('tujuan_kunjungan');
            $table->string('kontak');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('data_visitors');
    }
};
