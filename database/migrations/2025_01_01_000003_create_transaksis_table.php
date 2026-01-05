<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('transaksis', function (Blueprint $table) {
            $table->id();
            $table->foreignId('laporan_id')->constrained('laporans')->onDelete('cascade')->unique(); // One-to-one
            $table->string('invoice_number', 50)->unique();
            $table->decimal('biaya_total', 15, 2);
            $table->decimal('biaya_per_hektar', 12, 2)->default(2000000);
            $table->enum('status_pembayaran', ['pending', 'paid', 'failed', 'expired'])->default('pending');
            $table->string('payment_gateway', 50)->nullable();
            $table->string('payment_id_external', 255)->nullable();
            $table->string('invoice_pdf', 255)->nullable();
            $table->string('sertifikat_pdf', 255)->nullable();
            $table->timestamp('paid_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transaksis');
    }
};
