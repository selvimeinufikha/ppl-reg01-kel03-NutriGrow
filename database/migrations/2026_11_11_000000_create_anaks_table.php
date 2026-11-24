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
        Schema::create('anaks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('kehamilan_id')->nullable()->constrained('kehamilans')->nullOnDelete();
            $table->string('nama', 150);
            $table->string('nik', 30)->nullable();
            $table->enum('jenis_kelamin', ['Laki-laki', 'Perempuan']);
            $table->date('tanggal_lahir');
            $table->string('tempat_lahir', 100)->nullable();
            $table->unsignedTinyInteger('anak_ke')->nullable();
            $table->decimal('berat_lahir', 5, 2)->nullable()->comment('Berat lahir dalam kg');
            $table->decimal('panjang_lahir', 5, 2)->nullable()->comment('Panjang lahir dalam cm');
            $table->decimal('lingkar_kepala_lahir', 4, 1)->nullable()->comment('Lingkar kepala lahir dalam cm');
            $table->string('golongan_darah', 10)->nullable();
            $table->text('catatan')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('anaks');
    }
};
