<?php

namespace Database\Seeders;

use App\Models\Kehamilan;
use App\Models\PemeriksaanKehamilan;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class PemeriksaanKehamilanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Dapatkan nakes penanggung jawab (dr. Siti Nurhaliza / Admin)
        $nakes = User::where('role', 'admin')->first() ?: User::first();

        // 2. Data Pasien Ibu Hamil (Sesuai Referensi Tampilan UI)
        $patients = [
            [
                'email' => 'ratna.sari@gmail.com',
                'name' => 'Ny. Ratna Sari',
                'nik' => '3171025508920001',
                'no_kia' => 'KIA-JKT-2025-0101',
                'tanggal_lahir' => '1993-10-25', // 32 tahun
                'phone' => '081234560001',
                'alamat' => 'Jl. Kebon Sirih No. 12, Gambir, Jakarta Pusat',
                'gravida' => 'G2P1A0',
                'hpl' => '2025-12-28',
                'hpht' => '2025-03-23',
                'tinggi_badan' => 158.0,
                'berat_badan_pra_hamil' => 55.0,
                'lila_pra_hamil' => 24.5,
                'pemeriksaan' => [
                    'tgl_periksa' => '2025-10-24',
                    'jam_periksa' => '09:30',
                    'usia_gestasi_minggu' => 32,
                    'trimester' => 3,
                    'berat_badan' => 64.5,
                    'perubahan_bb' => 1.2,
                    'tekanan_darah' => '118/78',
                    'sistol' => 118,
                    'diastol' => 78,
                    'lila' => 25.0,
                    'hb' => 12.1,
                    'tfu' => 28.0,
                    'djj' => 142,
                    'status_kek' => 'normal',
                    'status_anemia' => 'normal',
                    'status_tekanan_darah' => 'optimal',
                    'kesimpulan_risiko' => 'Normal',
                    'catatan_klinis' => 'Lanjutkan konsumsi Tablet Tambah Darah (TTD) 1x1 tablet malam hari, konseling senam hamil Trimester 3, dan pemantauan gerakan janin mandiri.',
                    'tgl_kontrol_berikutnya' => '2025-11-21',
                ],
            ],
            [
                'email' => 'dewi.sartika@gmail.com',
                'name' => 'Ny. Dewi Sartika',
                'nik' => '3171094801970003',
                'no_kia' => 'KIA-JKT-2025-0102',
                'tanggal_lahir' => '1999-01-18', // 26 tahun
                'phone' => '081234560002',
                'alamat' => 'Jl. Tanah Abang II No. 45, Jakarta Pusat',
                'gravida' => 'G1P0A0',
                'hpl' => '2026-01-15',
                'hpht' => '2025-04-10',
                'tinggi_badan' => 152.0,
                'berat_badan_pra_hamil' => 45.0,
                'lila_pra_hamil' => 22.0,
                'pemeriksaan' => [
                    'tgl_periksa' => '2025-10-23',
                    'jam_periksa' => '10:15',
                    'usia_gestasi_minggu' => 28,
                    'trimester' => 3,
                    'berat_badan' => 49.2,
                    'perubahan_bb' => -0.3,
                    'tekanan_darah' => '105/70',
                    'sistol' => 105,
                    'diastol' => 70,
                    'lila' => 22.5,
                    'hb' => 11.2,
                    'tfu' => 24.0,
                    'djj' => 138,
                    'status_kek' => 'risiko_kek',
                    'status_anemia' => 'normal',
                    'status_tekanan_darah' => 'normal_rendah',
                    'kesimpulan_risiko' => 'Risiko KEK',
                    'catatan_klinis' => 'LiLA < 23.5 cm (Risiko KEK). Diberikan PMT Biskuit Ibu Hamil dan susu tinggi protein hewani. Evaluasi berat badan tiap 2 minggu.',
                    'tgl_kontrol_berikutnya' => '2025-11-06',
                ],
            ],
            [
                'email' => 'fitri.handayani@gmail.com',
                'name' => 'Ny. Fitri Handayani',
                'nik' => '3171046205930002',
                'no_kia' => 'KIA-JKT-2025-0103',
                'tanggal_lahir' => '1994-05-22', // 31 tahun
                'phone' => '081234560003',
                'alamat' => 'Jl. Cideng Timur No. 8, Gambir, Jakarta Pusat',
                'gravida' => 'G3P2A0',
                'hpl' => '2025-11-05',
                'hpht' => '2025-01-29',
                'tinggi_badan' => 160.0,
                'berat_badan_pra_hamil' => 58.0,
                'lila_pra_hamil' => 26.5,
                'pemeriksaan' => [
                    'tgl_periksa' => '2025-10-22',
                    'jam_periksa' => '11:00',
                    'usia_gestasi_minggu' => 38,
                    'trimester' => 3,
                    'berat_badan' => 68.0,
                    'perubahan_bb' => 0.8,
                    'tekanan_darah' => '120/82',
                    'sistol' => 120,
                    'diastol' => 82,
                    'lila' => 27.0,
                    'hb' => 10.4,
                    'tfu' => 32.0,
                    'djj' => 140,
                    'status_kek' => 'normal',
                    'status_anemia' => 'anemia_ringan',
                    'status_tekanan_darah' => 'normal',
                    'kesimpulan_risiko' => 'Anemia Ringan',
                    'catatan_klinis' => 'Usia kehamilan 38 minggu (Siap Salin). Hb 10.4 g/dL. Terapi tablet tambah darah ditingkatkan 2x1 tablet sampai masa nifas.',
                    'tgl_kontrol_berikutnya' => '2025-10-29',
                ],
            ],
            [
                'email' => 'siti.aminah@gmail.com',
                'name' => 'Ny. Siti Aminah',
                'nik' => '3171057003990004',
                'no_kia' => 'KIA-JKT-2025-0104',
                'tanggal_lahir' => '2001-03-30', // 24 tahun
                'phone' => '081234560004',
                'alamat' => 'Jl. Petojo Enklek No. 19, Gambir',
                'gravida' => 'G1P0A0',
                'hpl' => '2026-04-20',
                'hpht' => '2025-07-14',
                'tinggi_badan' => 156.0,
                'berat_badan_pra_hamil' => 53.0,
                'lila_pra_hamil' => 25.8,
                'pemeriksaan' => [
                    'tgl_periksa' => '2025-10-21',
                    'jam_periksa' => '08:45',
                    'usia_gestasi_minggu' => 14,
                    'trimester' => 2,
                    'berat_badan' => 56.0,
                    'perubahan_bb' => 0.5,
                    'tekanan_darah' => '122/80',
                    'sistol' => 122,
                    'diastol' => 80,
                    'lila' => 26.2,
                    'hb' => 12.8,
                    'tfu' => 12.0,
                    'djj' => 144,
                    'status_kek' => 'normal',
                    'status_anemia' => 'normal',
                    'status_tekanan_darah' => 'optimal',
                    'kesimpulan_risiko' => 'Normal',
                    'catatan_klinis' => 'Masuk Trimester 2 dalam kondisi fisik sangat baik. Edukasi nutrisi mikronutrien kalsium dan asam folat.',
                    'tgl_kontrol_berikutnya' => '2025-11-18',
                ],
            ],
            [
                'email' => 'linda.permata@gmail.com',
                'name' => 'Ny. Linda Permata',
                'nik' => '3171064906950005',
                'no_kia' => 'KIA-JKT-2025-0105',
                'tanggal_lahir' => '1996-06-09', // 29 tahun
                'phone' => '081234560005',
                'alamat' => 'Jl. Suryopranoto No. 3, Petojo Selatan',
                'gravida' => 'G2P0A1',
                'hpl' => '2026-03-08',
                'hpht' => '2025-06-01',
                'tinggi_badan' => 159.0,
                'berat_badan_pra_hamil' => 57.0,
                'lila_pra_hamil' => 23.8,
                'pemeriksaan' => [
                    'tgl_periksa' => '2025-10-19',
                    'jam_periksa' => '13:20',
                    'usia_gestasi_minggu' => 20,
                    'trimester' => 2,
                    'berat_badan' => 61.0,
                    'perubahan_bb' => 1.0,
                    'tekanan_darah' => '138/88',
                    'sistol' => 138,
                    'diastol' => 88,
                    'lila' => 24.0,
                    'hb' => 11.5,
                    'tfu' => 18.0,
                    'djj' => 136,
                    'status_kek' => 'normal',
                    'status_anemia' => 'normal',
                    'status_tekanan_darah' => 'pra_hipertensi',
                    'kesimpulan_risiko' => 'Pra-Hipertensi',
                    'catatan_klinis' => 'Waspada peningkatan tekanan darah (138/88 mmHg). Anjurkan diet rendah garam, istirahat cukup, dan cek urin reduksi/protein pada kunjungan berikutnya.',
                    'tgl_kontrol_berikutnya' => '2025-11-02',
                ],
            ],
            [
                'email' => 'nurul.hidayah@gmail.com',
                'name' => 'Ny. Nurul Hidayah',
                'nik' => '3171086012980006',
                'no_kia' => 'KIA-JKT-2025-0106',
                'tanggal_lahir' => '1998-12-20', // 27 tahun
                'phone' => '081234560006',
                'alamat' => 'Jl. Duri Pulo No. 27, Gambir',
                'gravida' => 'G1P0A0',
                'hpl' => '2025-12-12',
                'hpht' => '2025-03-07',
                'tinggi_badan' => 150.0,
                'berat_badan_pra_hamil' => 43.0,
                'lila_pra_hamil' => 21.0,
                'pemeriksaan' => [
                    'tgl_periksa' => '2025-10-18',
                    'jam_periksa' => '09:10',
                    'usia_gestasi_minggu' => 30,
                    'trimester' => 3,
                    'berat_badan' => 47.8,
                    'perubahan_bb' => -0.2,
                    'tekanan_darah' => '110/75',
                    'sistol' => 110,
                    'diastol' => 75,
                    'lila' => 21.8,
                    'hb' => 9.8,
                    'tfu' => 25.0,
                    'djj' => 146,
                    'status_kek' => 'risiko_kek',
                    'status_anemia' => 'anemia_sedang',
                    'status_tekanan_darah' => 'normal',
                    'kesimpulan_risiko' => 'Risiko KEK & Anemia',
                    'catatan_klinis' => 'Kombinasi Risiko KEK (LiLA 21.8 cm) dan Anemia Sedang (Hb 9.8 g/dL). Rujuk konsultasi dengan Dokter Spesialis Gizi Klinis / Dokter Sp.A.',
                    'tgl_kontrol_berikutnya' => '2025-11-01',
                ],
            ],
        ];

        foreach ($patients as $item) {
            // Buat atau perbarui User Ibu Hamil
            $user = User::updateOrCreate(
                ['email' => $item['email']],
                [
                    'name' => $item['name'],
                    'password' => Hash::make('password123'),
                    'role' => 'user',
                    'nik' => $item['nik'],
                    'no_kia' => $item['no_kia'],
                    'tanggal_lahir' => $item['tanggal_lahir'],
                    'phone' => $item['phone'],
                    'alamat' => $item['alamat'],
                    'faskes_name' => 'Puskesmas Gambir',
                ]
            );

            // Buat Data Kehamilan Aktif
            $kehamilan = Kehamilan::updateOrCreate(
                ['user_id' => $user->id, 'status' => 'aktif'],
                [
                    'gravida' => $item['gravida'],
                    'hpl' => $item['hpl'],
                    'hpht' => $item['hpht'],
                    'tinggi_badan' => $item['tinggi_badan'],
                    'berat_badan_pra_hamil' => $item['berat_badan_pra_hamil'],
                    'lila_pra_hamil' => $item['lila_pra_hamil'],
                    'status' => 'aktif',
                ]
            );

            // Buat Rekam Pemeriksaan Kehamilan (ANC)
            $p = $item['pemeriksaan'];
            PemeriksaanKehamilan::updateOrCreate(
                [
                    'kehamilan_id' => $kehamilan->id,
                    'tgl_periksa' => $p['tgl_periksa'],
                ],
                [
                    'user_id' => $user->id,
                    'nakes_id' => $nakes ? $nakes->id : null,
                    'jam_periksa' => $p['jam_periksa'],
                    'usia_gestasi_minggu' => $p['usia_gestasi_minggu'],
                    'trimester' => $p['trimester'],
                    'berat_badan' => $p['berat_badan'],
                    'perubahan_bb' => $p['perubahan_bb'],
                    'tekanan_darah' => $p['tekanan_darah'],
                    'sistol' => $p['sistol'],
                    'diastol' => $p['diastol'],
                    'lila' => $p['lila'],
                    'hb' => $p['hb'],
                    'tfu' => $p['tfu'],
                    'djj' => $p['djj'],
                    'status_kek' => $p['status_kek'],
                    'status_anemia' => $p['status_anemia'],
                    'status_tekanan_darah' => $p['status_tekanan_darah'],
                    'kesimpulan_risiko' => $p['kesimpulan_risiko'],
                    'catatan_klinis' => $p['catatan_klinis'],
                    'tgl_kontrol_berikutnya' => $p['tgl_kontrol_berikutnya'],
                ]
            );
        }
    }
}

