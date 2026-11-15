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
        Schema::create('fasilitas_kesehatans', function (Blueprint $table) {
            $table->id();
            $table->string('nama_fasilitas');
            $table->string('kode_faskes')->nullable();
            $table->string('jenis'); // puskesmas, posyandu, klinik, rumah_sakit
            $table->string('akreditasi')->nullable(); // e.g. Akreditasi Paripurna
            $table->text('alamat');
            $table->string('wilayah')->nullable(); // e.g. Gambir, Jakarta Pusat
            $table->string('jam_layanan'); // e.g. Senin - Jumat: 07.30 - 16.00 WIB
            $table->string('layanan_tambahan')->nullable(); // e.g. UGD & Bersalin 24 Jam
            $table->string('kontak'); // e.g. (021) 384-5120
            $table->string('pic')->nullable(); // e.g. Call Center 119 Ext. 2
            $table->decimal('latitude', 10, 7);
            $table->decimal('longitude', 10, 7);
            $table->string('status')->default('aktif'); // aktif, tidak_aktif
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fasilitas_kesehatans');
    }
};
