<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * PBI-001: Tabel pasangan untuk menyimpan data calon ayah & calon ibu.
     */
    public function up(): void
    {
        if (!Schema::hasTable('pasangans')) {
            Schema::create('pasangans', function (Blueprint $table) {
                $table->id();
                $table->foreignId('user_id')->constrained()->onDelete('cascade');
                $table->string('nama');
                $table->date('tanggal_lahir');
                $table->string('pekerjaan')->nullable();
                $table->enum('golongan_darah', ['A', 'B', 'AB', 'O'])->nullable();
                $table->enum('status_pasangan', ['suami', 'istri', 'calon_suami', 'calon_istri'])->default('suami');
                $table->timestamps();
            });
        } else {
            Schema::table('pasangans', function (Blueprint $table) {
                if (!Schema::hasColumn('pasangans', 'nama')) {
                    $table->string('nama')->nullable();
                }
                if (!Schema::hasColumn('pasangans', 'status_pasangan')) {
                    $table->string('status_pasangan', 30)->default('suami');
                }
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pasangans');
    }
};
