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
        Schema::table('users', function (Blueprint $table) {
            $table->string('nik', 20)->nullable()->unique()->after('phone');
            $table->string('no_kia', 30)->nullable()->after('nik');
            $table->date('tanggal_lahir')->nullable()->after('no_kia');
            $table->string('golongan_darah', 5)->nullable()->after('tanggal_lahir');
            $table->text('alamat')->nullable()->after('golongan_darah');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['nik', 'no_kia', 'tanggal_lahir', 'golongan_darah', 'alamat']);
        });
    }
};

