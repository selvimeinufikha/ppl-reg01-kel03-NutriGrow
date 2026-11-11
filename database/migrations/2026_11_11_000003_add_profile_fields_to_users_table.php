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
            if (!Schema::hasColumn('users', 'no_telepon')) {
                $table->string('no_telepon', 25)->nullable()->after('email');
            }
            if (!Schema::hasColumn('users', 'alamat')) {
                $table->text('alamat')->nullable()->after('no_telepon');
            }
            if (!Schema::hasColumn('users', 'kota')) {
                $table->string('kota', 100)->nullable()->after('alamat');
            }
            if (!Schema::hasColumn('users', 'kecamatan')) {
                $table->string('kecamatan', 100)->nullable()->after('kota');
            }
            if (!Schema::hasColumn('users', 'kelurahan')) {
                $table->string('kelurahan', 100)->nullable()->after('kecamatan');
            }
            if (!Schema::hasColumn('users', 'nik')) {
                $table->string('nik', 20)->nullable()->after('kelurahan');
            }
            if (!Schema::hasColumn('users', 'tanggal_lahir')) {
                $table->date('tanggal_lahir')->nullable()->after('nik');
            }
            if (!Schema::hasColumn('users', 'foto_profil')) {
                $table->string('foto_profil')->nullable()->after('tanggal_lahir');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $columnsToDrop = [];
            foreach (['no_telepon', 'alamat', 'kota', 'kecamatan', 'kelurahan', 'nik', 'tanggal_lahir', 'foto_profil'] as $col) {
                if (Schema::hasColumn('users', $col)) {
                    $columnsToDrop[] = $col;
                }
            }
            if (!empty($columnsToDrop)) {
                $table->dropColumn($columnsToDrop);
            }
        });
    }
};
