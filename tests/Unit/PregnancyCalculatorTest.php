<?php

namespace Tests\Unit;

use App\Services\PregnancyCalculatorService;
use Carbon\Carbon;
use PHPUnit\Framework\TestCase;

class PregnancyCalculatorTest extends TestCase
{
    /**
     * Test: Fungsi perhitungan perkiraan hari lahir (HPL) dengan rumus Naegele (+280 hari).
     */
    public function test_perhitungan_hpl_rumus_naegele_akurat(): void
    {
        // Contoh HPHT: 23 Desember 2023 -> HPL: 28 September 2024
        $hpht = '2023-12-23';
        $hpl = PregnancyCalculatorService::hitungHpl($hpht);

        $this->assertEquals('2024-09-28', $hpl->format('Y-m-d'));
        $this->assertEquals(280, Carbon::parse($hpht)->diffInDays($hpl));
    }

    /**
     * Test: Fungsi perhitungan usia kehamilan (minggu dan hari).
     */
    public function test_perhitungan_usia_kehamilan_minggu_dan_hari(): void
    {
        $hpht = '2023-12-23';
        // 171 hari setelah HPHT = 24 minggu 3 hari (171 / 7 = 24 sisa 3)
        $tanggalAcuan = Carbon::parse($hpht)->addDays(171);

        $hasil = PregnancyCalculatorService::hitungUsiaKehamilan($hpht, $tanggalAcuan);

        $this->assertEquals(171, $hasil['total_hari']);
        $this->assertEquals(24, $hasil['minggu']);
        $this->assertEquals(3, $hasil['hari']);
        $this->assertEquals('24 Minggu 3 Hari', $hasil['formatted']);
        $this->assertEquals(109, $hasil['sisa_hari']); // 280 - 171
        $this->assertGreaterThan(60.0, $hasil['persentase']);
    }

    /**
     * Test: Fungsi penentuan trimester berdasarkan usia gestasi dalam minggu.
     * Standar Kemenkes RI / WHO:
     * - Trimester 1: 1 - 13 minggu
     * - Trimester 2: 14 - 27 minggu
     * - Trimester 3: 28 - 40+ minggu
     */
    public function test_penentuan_trimester_secara_tepat(): void
    {
        // 1. Trimester 1
        $t1Awal = PregnancyCalculatorService::tentukanTrimester(6);
        $this->assertEquals(1, $t1Awal['nomor']);
        $this->assertEquals('Trimester 1', $t1Awal['nama']);
        $this->assertEquals('T1 Aktif', $t1Awal['badge']);

        $t1Akhir = PregnancyCalculatorService::tentukanTrimester(13);
        $this->assertEquals(1, $t1Akhir['nomor']);

        // 2. Trimester 2
        $t2Awal = PregnancyCalculatorService::tentukanTrimester(14);
        $this->assertEquals(2, $t2Awal['nomor']);
        $this->assertEquals('Trimester 2', $t2Awal['nama']);
        $this->assertEquals('T2 Aktif', $t2Awal['badge']);

        $t2Tengah = PregnancyCalculatorService::tentukanTrimester(24);
        $this->assertEquals(2, $t2Tengah['nomor']);

        $t2Akhir = PregnancyCalculatorService::tentukanTrimester(27);
        $this->assertEquals(2, $t2Akhir['nomor']);

        // 3. Trimester 3
        $t3Awal = PregnancyCalculatorService::tentukanTrimester(28);
        $this->assertEquals(3, $t3Awal['nomor']);
        $this->assertEquals('Trimester 3', $t3Awal['nama']);
        $this->assertEquals('T3 Aktif', $t3Awal['badge']);

        $t3Aterm = PregnancyCalculatorService::tentukanTrimester(39);
        $this->assertEquals(3, $t3Aterm['nomor']);
    }

    /**
     * Test: Milestone janin dan panduan nutrisi terisi lengkap sesuai trimester.
     */
    public function test_milestone_dan_panduan_nutrisi_lengkap(): void
    {
        $milestone = PregnancyCalculatorService::getMilestoneJanin(24);
        $this->assertStringContainsString('Jagung Manis', $milestone['nama']);
        $this->assertNotEmpty($milestone['panjang']);
        $this->assertNotEmpty($milestone['berat']);

        $trimester = PregnancyCalculatorService::tentukanTrimester(24);
        $this->assertNotEmpty($trimester['asupan_nutrisi']);
        $this->assertNotEmpty($trimester['fokus_kesehatan']);
    }

    /**
     * Test Acceptance Criteria: Sistem menghitung perkiraan hari lahir, usia kehamilan (minggu), dan trimester dari HPHT.
     */
    public function test_sistem_menghitung_hpl_usia_kehamilan_minggu_dan_trimester_dari_hpht(): void
    {
        $hpht = '2023-12-23';
        $tanggalAcuan = Carbon::parse($hpht)->addDays(171); // 24 minggu 3 hari

        $detail = PregnancyCalculatorService::hitungLengkap($hpht, $tanggalAcuan);

        // 1. Memeriksa Perkiraan Hari Lahir (HPL)
        $this->assertEquals('2024-09-28', $detail['hpl']);

        // 2. Memeriksa Usia Kehamilan dalam Minggu
        $this->assertEquals(24, $detail['usia_minggu']);
        $this->assertEquals('24 Minggu 3 Hari', $detail['usia_kehamilan']);

        // 3. Memeriksa Penentuan Trimester
        $this->assertEquals(2, $detail['trimester']['nomor']);
        $this->assertEquals('Trimester 2 (14–27 Mg)', $detail['trimester']['label']);
    }
}
