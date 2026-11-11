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
        // 1. Tabel Anak
        if (!Schema::hasTable('anaks')) {
            Schema::create('anaks', function (Blueprint $table) {
                $table->id();
                $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();
                $table->string('nama');
                $table->string('nik', 20)->nullable()->unique();
                $table->enum('jenis_kelamin', ['Perempuan', 'Laki-Laki'])->default('Perempuan');
                $table->date('tanggal_lahir');
                $table->string('status_gizi')->default('Batita Aktif & Sehat');
                $table->timestamps();
            });
        }

        // 2. Tabel Catatan Riwayat Tumbuh Kembang Antropometri
        if (!Schema::hasTable('riwayat_tumbuh_kembang')) {
            Schema::create('riwayat_tumbuh_kembang', function (Blueprint $table) {
                $table->id();
                $table->foreignId('anak_id')->constrained('anaks')->cascadeOnDelete();
                $table->date('tanggal_pemeriksaan');
                $table->integer('usia_bulan');
                $table->decimal('berat_badan', 5, 2); // kg
                $table->decimal('tinggi_badan', 5, 2); // cm
                $table->decimal('lingkar_kepala', 5, 2)->nullable(); // cm
                $table->decimal('lingkar_lengan_atas', 5, 2)->nullable(); // cm
                $table->string('z_score_bb_u')->nullable();
                $table->string('z_score_tb_u')->nullable();
                $table->string('z_score_bb_tb')->nullable();
                $table->string('status_pertumbuhan')->default('Pertumbuhan Baik & Normal');
                $table->enum('status_type', ['normal', 'warning', 'danger'])->default('normal');
                $table->text('catatan_klinis')->nullable();
                $table->string('nama_nakes')->nullable();
                $table->string('faskes_pemeriksa')->nullable();
                $table->string('kpsp_status')->nullable();
                $table->string('imunisasi')->nullable();
                $table->string('vitamin_a')->nullable();
                $table->string('obat_cacing')->nullable();
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('riwayat_tumbuh_kembang');
        Schema::dropIfExists('anaks');
    }
};
