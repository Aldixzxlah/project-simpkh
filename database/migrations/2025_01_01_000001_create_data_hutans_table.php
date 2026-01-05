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
        Schema::create('data_hutans', function (Blueprint $table) {
            $table->id();
            $table->string('provinsi', 100);
            $table->string('pulau', 50)->nullable();
            $table->decimal('luas_hektar', 15, 2);
            $table->json('jenis_vegetasi')->nullable();
            $table->enum('status_konservasi', ['konservasi', 'lindung', 'produksi', 'konversi']);
            $table->longText('geojson')->nullable();
            $table->year('tahun_data')->default(2025);
            $table->foreignId('updated_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
            $table->softDeletes();

            $table->index('provinsi');
            $table->index('status_konservasi');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('data_hutans');
    }
};
