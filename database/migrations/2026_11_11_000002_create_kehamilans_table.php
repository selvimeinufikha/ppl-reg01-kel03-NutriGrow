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
        Schema::create('kehamilans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('pasangan_id')->nullable()->constrained('pasangans')->nullOnDelete();
            $table->unsignedInteger('kehamilan_ke')->default(1);
            $table->date('hpht'); // Hari Pertama Haid Terakhir
            $table->date('hpl')->nullable();  // Hari Perkiraan Lahir
            $table->string('status', 30)->default('berlangsung'); // 'berlangsung', 'melahirkan', 'keguguran'
            $table->string('gravida', 20)->nullable(); // e.g. G2P1A0
            $table->date('tanggal_persalinan')->nullable();
            $table->string('status_persalinan')->nullable(); // e.g. 'Aterm (Cukup Bulan)'
            $table->string('nama_anak')->nullable(); // jika status sudah melahirkan
            $table->decimal('tinggi_badan', 5, 2)->nullable(); // cm
            $table->decimal('berat_badan_pra_hamil', 5, 2)->nullable(); // kg
            $table->decimal('lila_pra_hamil', 4, 1)->nullable(); // cm
            $table->text('catatan')->nullable(); // Catatan kondisi ibu / perkembangan
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kehamilans');
    }
};
