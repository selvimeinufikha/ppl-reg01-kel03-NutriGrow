<?php

namespace Database\Seeders;

use App\Models\InformasiNutrisi;
use App\Models\User;
use Illuminate\Database\Seeder;

class InformasiNutrisiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin = User::where('role', 'admin')->first() ?? User::first();
        $adminId = $admin ? $admin->id : 1;

        $data = [
            [
                'nama_bahan_menu' => 'Ikan Kembung & Telur Ayam: Sumber Protein Hewani Terjangkau',
                'kategori_fase' => 'Masa Kehamilan',
                'kategori_kondisi' => 'Makanan Bergizi',
                'kandungan_gizi' => 'DHA, Protein 18g, Omega-3, Zat Besi',
                'saran_penggunaan' => 'Protein hewani memiliki asam amino esensial lengkap yang terbukti efektif mendukung pertambahan tinggi badan dan mencegah risiko stunting pada 1000 Hari Pertama Kehidupan. Konsumsi 1-2 butir telur dan 1 porsi ikan kembung per hari secara teratur.',
                'deskripsi_manfaat' => 'Ikan kembung lokal Indonesia memiliki kadar asam lemak Omega-3 dan DHA yang bahkan lebih tinggi dari ikan salmon impor. Sangat penting bagi perkembangan jaringan otak janin dan retina mata balita.',
                'foto' => 'https://images.unsplash.com/photo-1544025162-d76694265947?auto=format&fit=crop&w=600&q=80',
                'created_by' => $adminId,
            ],
            [
                'nama_bahan_menu' => 'Alpukat & Susu Segar: Lemak Sehat & Kalsium Janin',
                'kategori_fase' => 'Masa Kehamilan',
                'kategori_kondisi' => 'Zat Gizi',
                'kandungan_gizi' => 'Asam Folat, Kalsium 300mg, Kalium, Vit E',
                'saran_penggunaan' => 'Kaya asam folat alami untuk mendukung pembentukan tabung saraf tulang belakang janin di trimester awal serta menjaga kepadatan tulang ibu hamil. Konsumsi 1 gelas susu segar di pagi hari dan 1/2 buah alpukat sebagai camilan sehat.',
                'deskripsi_manfaat' => 'Asam folat (vitamin B9) sangat krusial pada 28 hari pertama kehamilan untuk mencegah cacat tabung saraf (neural tube defects/spina bifida). Kalsium menjaga kestabilan tekanan darah ibu dan pembentukan kerangka tulang janin.',
                'foto' => 'https://images.unsplash.com/photo-1523049673857-eb18f1d7b578?auto=format&fit=crop&w=600&q=80',
                'created_by' => $adminId,
            ],
            [
                'nama_bahan_menu' => 'Porsi \'Isi Piringku\': Pedoman Seimbang 3 Kali Sehari',
                'kategori_fase' => 'Masa Kehamilan',
                'kategori_kondisi' => 'Edukasi Gizi',
                'kandungan_gizi' => '1/2 Piring Sayur/Buah, 1/2 Karbo/Lauk Hewani',
                'saran_penggunaan' => 'Panduan praktis visual Kementerian Kesehatan untuk memastikan pembagian porsi makan keluarga memenuhi kebutuhan makronutrien dan mikronutrien harian. 2/3 dari setengah piring makanan pokok, 1/3 lauk pauk, 2/3 sayuran, 1/3 buah-buahan.',
                'deskripsi_manfaat' => 'Konsep Isi Piringku menggantikan slogan 4 Sehat 5 Sempurna dengan penekanan pada proporsi nyata saat makan: membatasi gula, garam, dan lemak, serta memastikan hidrasi minimal 8-10 gelas air putih sehari.',
                'foto' => 'https://images.unsplash.com/photo-1546069901-ba9599a7e63c?auto=format&fit=crop&w=600&q=80',
                'created_by' => $adminId,
            ],
            [
                'nama_bahan_menu' => 'Hati Ayam & Bayam Merah: Cegah Anemia & Bayi BBLR',
                'kategori_fase' => 'Persiapan Kehamilan',
                'kategori_kondisi' => 'Pencegahan Stunting',
                'kandungan_gizi' => 'Zat Besi Heme 12mg, Vitamin A, Folat, Vitamin B12',
                'saran_penggunaan' => 'Zat besi heme dari hati ayam memiliki daya serap 3x lebih tinggi dibanding nabati. Sangat direkomendasikan untuk calon ibu dan ibu hamil trimester 2 dan 3 untuk mencegah anemia defisiensi besi dan kelahiran prematur.',
                'deskripsi_manfaat' => 'Anemia pada ibu hamil meningkatkan risiko 4x lipat bayi lahir dengan berat badan lahir rendah (BBLR) yang menjadi pintu masuk utama stunting pada balita.',
                'foto' => 'https://images.unsplash.com/photo-1506084868230-bb9d95c24759?auto=format&fit=crop&w=600&q=80',
                'created_by' => $adminId,
            ],
            [
                'nama_bahan_menu' => 'Sup Daging Sapi & Kacang Merah: Padat Kalori & Seng (Zinc)',
                'kategori_fase' => 'Ibu Menyusui',
                'kategori_kondisi' => 'Makanan Bergizi',
                'kandungan_gizi' => 'Zinc 6.5mg, Protein 24g, Kolagen, Vitamin B Kompleks',
                'saran_penggunaan' => 'Mendukung regenerasi sel darah, mempercepat penyembuhan pasca persalinan, dan melancarkan produksi ASI berkualitas tinggi. Minum kuah kaldu hangat untuk menambah asupan cairan harian.',
                'deskripsi_manfaat' => 'Zinc (seng) memegang peranan kunci dalam imunitas seluler bayi dan sintesis DNA. Ibu menyusui membutuhkan tambahan 500 kkal per hari dengan kualitas protein hewani tinggi.',
                'foto' => 'https://images.unsplash.com/photo-1547592166-23ac45744acd?auto=format&fit=crop&w=600&q=80',
                'created_by' => $adminId,
            ],
            [
                'nama_bahan_menu' => 'Bubur Tim Hati Ayam, Telur Puyuh & Labu Kuning: MPASI Padat Gizi',
                'kategori_fase' => 'Tumbuh Kembang Anak',
                'kategori_kondisi' => 'Pencegahan Stunting',
                'kandungan_gizi' => 'Zat Besi, Vitamin A, Protein Hewani 8g, Lemak Sehat',
                'saran_penggunaan' => 'Diberikan pada anak mulai usia 6 bulan ke atas. Tekstur disesuaikan bertahap (lumat halus ke cincang). Pastikan terdapat sumber lemak tambahan (minyak kelapa/santan/margarin) untuk penyerapan vitamin larut lemak.',
                'deskripsi_manfaat' => 'Usia 6-23 bulan adalah periode paling rawan terjadinya stunting jika MPASI tidak mengandung protein hewani yang cukup. Telur dan hati ayam merupakan kombinasi emas pencegahan stunting paling terjangkau.',
                'foto' => 'https://images.unsplash.com/photo-1512621776951-a57141f2eefd?auto=format&fit=crop&w=600&q=80',
                'created_by' => $adminId,
            ],
        ];

        foreach ($data as $item) {
            InformasiNutrisi::updateOrCreate(
                ['nama_bahan_menu' => $item['nama_bahan_menu']],
                $item
            );
        }
    }
}
