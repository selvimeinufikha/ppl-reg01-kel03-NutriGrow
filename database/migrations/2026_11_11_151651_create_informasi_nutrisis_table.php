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
        Schema::create('informasi_nutrisis', function (Blueprint $table) {
            $table->id();
            $table->string('nama_bahan_menu'); // Nama bahan atau menu makanan/gizi
            $table->string('kategori_fase'); // Persiapan Kehamilan, Masa Kehamilan, Ibu Menyusui, Tumbuh Kembang Anak, dsb.
            $table->string('kategori_kondisi'); // Makanan Bergizi, Zat Gizi, Edukasi Gizi, Pencegahan Stunting, dsb.
            $table->text('kandungan_gizi'); // Kandungan gizi utama (e.g. Asam Folat, Protein 18g, Zat Besi, Kalsium)
            $table->text('saran_penggunaan'); // Saran penyajian / petunjuk konsumsi / anjuran gizi
            $table->string('foto')->nullable(); // Foto/gambar pendukung
            $table->text('deskripsi_manfaat')->nullable(); // Penjelasan manfaat detail
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete(); // Admin pembuat
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('informasi_nutrisis');
    }
};
