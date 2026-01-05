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
        Schema::create('laporans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->string('nomor_laporan', 50)->unique()->nullable();
            $table->string('judul', 255);
            $table->enum('keperluan', ['industri_kayu', 'pertambangan', 'pariwisata', 'perkebunan', 'lainnya']);
            $table->json('lokasi_polygon');
            $table->decimal('luas_dimohon', 12, 2);
            $table->text('alasan');
            $table->text('dampak_lingkungan')->nullable();
            $table->json('dokumen')->nullable();
            $table->enum('status', ['draft', 'pending', 'approved', 'rejected', 'revisi'])->default('draft');
            $table->text('catatan_admin')->nullable();
            $table->foreignId('reviewed_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamp('reviewed_at')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->index('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('laporans');
    }
};
