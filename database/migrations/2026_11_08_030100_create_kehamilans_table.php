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
        if (!Schema::hasTable('kehamilans')) {
            Schema::create('kehamilans', function (Blueprint $table) {
                $table->id();
                $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
                $table->string('gravida', 50)->default('Kehamilan Ke-1'); // e.g. Kehamilan Ke-1 / G1P0A0
                $table->date('hpht')->nullable(); // Hari Pertama Haid Terakhir
                $table->date('hpl')->nullable();  // Hari Perkiraan Lahir
                $table->decimal('tinggi_badan', 5, 2)->nullable(); // cm
                $table->decimal('berat_badan_pra_hamil', 5, 2)->nullable(); // kg
                $table->decimal('lila_pra_hamil', 4, 1)->nullable(); // cm
                $table->text('faktor_risiko')->nullable();
                $table->string('status', 20)->default('aktif'); // 'aktif', 'melahirkan', 'keguguran'
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kehamilans');
    }
};
