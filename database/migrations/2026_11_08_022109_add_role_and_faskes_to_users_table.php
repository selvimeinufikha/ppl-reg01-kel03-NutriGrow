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
            $table->string('role')->default('user')->after('password');
            $table->string('faskes_name')->nullable()->after('role');
            $table->string('nip_str')->nullable()->after('faskes_name');
            $table->string('phone')->nullable()->after('nip_str');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['role', 'faskes_name', 'nip_str', 'phone']);
        });
    }
};
