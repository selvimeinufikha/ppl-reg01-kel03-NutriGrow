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
        Schema::create('pemeriksaan_kehamilans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('kehamilan_id')->constrained('kehamilans')->onDelete('cascade');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('nakes_id')->nullable()->constrained('users')->onDelete('set null');
            
            $table->date('tgl_periksa');
            $table->string('jam_periksa', 10)->default('09:00');
            $table->integer('usia_gestasi_minggu');
            $table->unsignedTinyInteger('trimester')->default(1);
            
            // Antropometri & Tanda Vital
            $table->decimal('berat_badan', 5, 2); // kg, e.g. 64.50
            $table->decimal('perubahan_bb', 4, 2)->nullable(); // kg, e.g. +1.20
            $table->string('tekanan_darah', 20); // e.g. '118/78'
            $table->unsignedSmallInteger('sistol')->nullable();
            $table->unsignedSmallInteger('diastol')->nullable();
            $table->decimal('lila', 4, 1); // cm, e.g. 25.0 (< 23.5 Risiko KEK)
            $table->decimal('hb', 4, 1)->nullable(); // g/dL, e.g. 12.1 (< 11.0 Anemia)
            $table->decimal('tfu', 4, 1)->nullable(); // cm, e.g. 28.0
            $table->unsignedSmallInteger('djj')->nullable(); // dpm, e.g. 142
            
            // Penilaian Risiko Klinis Otomatis
            $table->string('status_kek', 30)->default('normal'); // 'normal', 'risiko_kek'
            $table->string('status_anemia', 30)->default('normal'); // 'normal', 'anemia_ringan', 'anemia_sedang', 'anemia_berat'
            $table->string('status_tekanan_darah', 30)->default('optimal'); // 'optimal', 'normal', 'pra_hipertensi', 'hipertensi'
            $table->string('kesimpulan_risiko', 50)->default('Normal');
            
            // Catatan & Jadwal Kontrol
            $table->text('catatan_klinis')->nullable();
            $table->date('tgl_kontrol_berikutnya')->nullable();
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pemeriksaan_kehamilans');
    }
};

