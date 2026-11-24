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
            // ==========================================
            // FASE 1: PERSIAPAN KEHAMILAN (5 ITEM)
            // ==========================================
            [
                'nama_bahan_menu' => 'Hati Ayam & Bayam Merah: Cegah Anemia & Bayi BBLR',
                'kategori_fase' => 'Persiapan Kehamilan',
                'kategori_kondisi' => 'Pencegahan Stunting',
                'kandungan_gizi' => 'Zat Besi Heme 12mg, Vitamin A, Folat, B12',
                'saran_penggunaan' => 'Zat besi heme dari hati ayam memiliki daya serap 3x lebih tinggi dibanding nabati. Sangat direkomendasikan untuk calon ibu untuk mencegah anemia defisiensi besi sebelum hamil.',
                'deskripsi_manfaat' => 'Anemia pada masa prakonsepsi meningkatkan risiko bayi lahir prematur dan BBLR. Kombinasikan bayam merah dan hati ayam 1-2 kali seminggu untuk cadangan hemoglobin optimal.',
                'foto' => 'https://images.unsplash.com/photo-1506084868230-bb9d95c24759?auto=format&fit=crop&w=600&q=80',
                'created_by' => $adminId,
            ],
            [
                'nama_bahan_menu' => 'Jus Alpukat, Madu Murni & Biji Labu: Optimalkan Sel Telur',
                'kategori_fase' => 'Persiapan Kehamilan',
                'kategori_kondisi' => 'Zat Gizi',
                'kandungan_gizi' => 'Vitamin E, Seng (Zinc) 4.2mg, Asam Lemak Sehat, Folat',
                'saran_penggunaan' => 'Kombinasi vitamin E dan zinc sangat penting bagi perbaikan kualitas sel telur (ovum) dan lapisan dinding rahim (endometrium) menjelang ovulasi.',
                'deskripsi_manfaat' => 'Antioksidan alami dalam biji labu dan alpukat menangkal radikal bebas yang berisiko merusak struktur materi genetik sel telur calon ibu.',
                'foto' => 'https://images.unsplash.com/photo-1523049673857-eb18f1d7b578?auto=format&fit=crop&w=600&q=80',
                'created_by' => $adminId,
            ],
            [
                'nama_bahan_menu' => 'Ikan Salmon Panggang & Brokoli Rebus: Sumber Omega-3 Prakonsepsi',
                'kategori_fase' => 'Persiapan Kehamilan',
                'kategori_kondisi' => 'Makanan Bergizi',
                'kandungan_gizi' => 'Omega-3 DHA 1200mg, Protein 22g, Asam Folat 140mcg',
                'saran_penggunaan' => 'Asam lemak esensial Omega-3 membantu melancarkan aliran darah ke organ reproduksi dan menyeimbangkan hormon estrogen calon ibu.',
                'deskripsi_manfaat' => 'Kandungan asam folat alami dari brokoli kukus mencegah cacat tabung saraf janin sejak hari-hari pertama pembuahan sebelum tes kehamilan positif.',
                'foto' => 'https://images.unsplash.com/photo-1467003909585-2f8a72700288?auto=format&fit=crop&w=600&q=80',
                'created_by' => $adminId,
            ],
            [
                'nama_bahan_menu' => 'Telur Rebus & Sari Kacang Hijau: Asam Amino & Vitamin B Kompleks',
                'kategori_fase' => 'Persiapan Kehamilan',
                'kategori_kondisi' => 'Makanan Bergizi',
                'kandungan_gizi' => 'Protein 14g, Kolin 150mg, Vitamin B1, B6, Zat Besi',
                'saran_penggunaan' => 'Sarapan praktis dan terjangkau bagi calon ibu pekerja. Konsumsi 1-2 butir telur rebus dengan semangkuk bubur/sari kacang hijau rendah gula.',
                'deskripsi_manfaat' => 'Kolin dan vitamin B kompleks mendukung metabolisme seluler serta pembentukan cadangan energi yang siap menopang kehamilan trimester pertama.',
                'foto' => 'https://images.unsplash.com/photo-1582722872445-44dc5f7e3c8f?auto=format&fit=crop&w=600&q=80',
                'created_by' => $adminId,
            ],
            [
                'nama_bahan_menu' => 'Susu Fortifikasi Prakonsepsi & Buah Beri: Kalsium & Antioksidan',
                'kategori_fase' => 'Persiapan Kehamilan',
                'kategori_kondisi' => 'Zat Gizi',
                'kandungan_gizi' => 'Kalsium 400mg, Asam Folat 400mcg, Vitamin D3, Antioksidan',
                'saran_penggunaan' => 'Minum 1 gelas susu persiapan kehamilan setiap pagi atau malam hari disertai buah segar sebagai camilan sore.',
                'deskripsi_manfaat' => 'Kalsium dan vitamin D mempersiapkan kepadatan tulang ibu agar tidak terdeplesi saat janin menyerap kalsium dalam jumlah besar kelak.',
                'foto' => 'https://images.unsplash.com/photo-1550583724-b2692b85b150?auto=format&fit=crop&w=600&q=80',
                'created_by' => $adminId,
            ],

            // ==========================================
            // FASE 2: MASA KEHAMILAN (6 ITEM - SESUAI FIGMA)
            // ==========================================
            [
                'nama_bahan_menu' => 'Ikan Kembung & Telur Ayam: Sumber Protein Hewani Terjangkau',
                'kategori_fase' => 'Masa Kehamilan',
                'kategori_kondisi' => 'Makanan Bergizi',
                'kandungan_gizi' => 'DHA, Protein 18g, Omega-3, Zat Besi',
                'saran_penggunaan' => 'Protein hewani memiliki asam amino esensial lengkap yang terbukti efektif mendukung pertambahan tinggi badan dan mencegah risiko stunting pada 1000 Hari Pertama Kehidupan. Konsumsi 1-2 butir telur dan 1 porsi ikan kembung per hari secara teratur.',
                'deskripsi_manfaat' => 'Ikan kembung lokal Indonesia memiliki kadar asam lemak Omega-3 dan DHA yang bahkan lebih tinggi dari ikan salmon impor. Sangat penting bagi perkembangan jaringan otak janin dan retina mata.',
                'foto' => 'https://images.unsplash.com/photo-1544025162-d76694265947?auto=format&fit=crop&w=600&q=80',
                'created_by' => $adminId,
            ],
            [
                'nama_bahan_menu' => 'Alpukat & Susu Segar: Lemak Sehat & Kalsium Janin',
                'kategori_fase' => 'Masa Kehamilan',
                'kategori_kondisi' => 'Zat Gizi',
                'kandungan_gizi' => 'Asam Folat, Kalsium 300mg, Kalium, Vit E',
                'saran_penggunaan' => 'Kaya asam folat alami untuk mendukung pembentukan tabung saraf tulang belakang janin di trimester awal serta menjaga kepadatan tulang ibu hamil. Konsumsi 1 gelas susu segar di pagi hari dan 1/2 buah alpukat sebagai camilan sehat.',
                'deskripsi_manfaat' => 'Asam folat (vitamin B9) sangat krusial pada 28 hari pertama kehamilan untuk mencegah cacat tabung saraf (neural tube defects/spina bifida). Kalsium menjaga kestabilan tekanan darah ibu.',
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
                'nama_bahan_menu' => 'Sup Daging Sapi & Tomat: Zat Besi & Vitamin C Pembentuk Darah Janin',
                'kategori_fase' => 'Masa Kehamilan',
                'kategori_kondisi' => 'Pencegahan Stunting',
                'kandungan_gizi' => 'Zat Besi Heme 8mg, Protein 22g, Vitamin C 45mg',
                'saran_penggunaan' => 'Sangat dianjurkan untuk ibu hamil trimester 2 dan 3 saat volume darah meningkat hingga 50%. Vitamin C dari tomat melipatgandakan penyerapan zat besi dari daging sapi.',
                'deskripsi_manfaat' => 'Mencegah terjadinya anemia gestasional yang menyebabkan pertumbuhan janin terhambat (IUGR) dan risiko perdarahan pasca persalinan.',
                'foto' => 'https://images.unsplash.com/photo-1547592166-23ac45744acd?auto=format&fit=crop&w=600&q=80',
                'created_by' => $adminId,
            ],
            [
                'nama_bahan_menu' => 'Yoghurt Yunani, Stroberi & Biji Chia: Probiotik & Kalsium Redakan Sembelit',
                'kategori_fase' => 'Masa Kehamilan',
                'kategori_kondisi' => 'Zat Gizi',
                'kandungan_gizi' => 'Kalsium 250mg, Probiotik Alami, Serat 6g, Protein 15g',
                'saran_penggunaan' => 'Pilihan camilan sehat saat ibu hamil mengalami sembelit akibat hormon progesteron atau suplemen zat besi. Konsumsi 1 mangkuk kecil dingin saat sore hari.',
                'deskripsi_manfaat' => 'Probiotik lactobacillus menjaga keseimbangan flora usus ibu dan memperkuat imunitas bawaan yang nantinya ditransfer ke janin.',
                'foto' => 'https://images.unsplash.com/photo-1488477181946-6428a0291777?auto=format&fit=crop&w=600&q=80',
                'created_by' => $adminId,
            ],
            [
                'nama_bahan_menu' => 'Pepes Ikan Mas & Tahu Kuning: Bebas Kolesterol & Tulang Janin Kuat',
                'kategori_fase' => 'Masa Kehamilan',
                'kategori_kondisi' => 'Makanan Bergizi',
                'kandungan_gizi' => 'Kalsium 320mg, Fosfor, Protein 19g, Kurkumin Kunyit',
                'saran_penggunaan' => 'Metode pepes (kukus bungkus daun pisang) bebas minyak goreng jenuh, sangat baik untuk menjaga tekanan darah ibu tetap normal dan terhindar dari preeklampsia.',
                'deskripsi_manfaat' => 'Kalsium dari duri lunak ikan mas dan tahu mempercepat mineralisasi tulang serta bakal gigi janin di trimester akhir.',
                'foto' => 'https://images.unsplash.com/photo-1519708227418-c8fd9a32b7a2?auto=format&fit=crop&w=600&q=80',
                'created_by' => $adminId,
            ],

            // ==========================================
            // FASE 3: IBU MENYUSUI (5 ITEM)
            // ==========================================
            [
                'nama_bahan_menu' => 'Sayur Daun Katuk & Ikan Gabus: Booster Alami ASI & Pemulihan Luka',
                'kategori_fase' => 'Ibu Menyusui',
                'kategori_kondisi' => 'Makanan Bergizi',
                'kandungan_gizi' => 'Senyawa Laktagogum, Albumin 21%, Kalsium, Kalium',
                'saran_penggunaan' => 'Kombinasi legendaris ibu menyusui Indonesia. Daun katuk merangsang hormon prolaktin dan oksitosin untuk melancarkan pancaran ASI, sementara albumin ikan gabus mempercepat penutupan luka jahitan melahirkan.',
                'deskripsi_manfaat' => 'Tingginya kadar albumin mempercepat regenerasi jaringan rahim dan dinding perut ibu nifas secara aman dan alami.',
                'foto' => 'https://images.unsplash.com/photo-1540420773420-3366772f4999?auto=format&fit=crop&w=600&q=80',
                'created_by' => $adminId,
            ],
            [
                'nama_bahan_menu' => 'Sup Ayam Kampung & Jahe Hangat: Pemulihan Energi & Lancar Sirkulasi',
                'kategori_fase' => 'Ibu Menyusui',
                'kategori_kondisi' => 'Makanan Bergizi',
                'kandungan_gizi' => 'Kolagen, Protein 26g, Kaldu Elektrolit, Gingerol',
                'saran_penggunaan' => 'Sajikan kuah kaldu hangat setiap kali makan utama. Ibu menyusui memerlukan cairan ekstra (+700-1000ml) per hari yang bisa dipenuhi dari kuah sup kaya nutrisi.',
                'deskripsi_manfaat' => 'Meredakan rasa dingin, meriang, dan lelah pasca melahirkan sekaligus meningkatkan pasokan protein pembentuk imunoglobulin ASI.',
                'foto' => 'https://images.unsplash.com/photo-1547592166-23ac45744acd?auto=format&fit=crop&w=600&q=80',
                'created_by' => $adminId,
            ],
            [
                'nama_bahan_menu' => 'Kacang Almond Panggang & Susu Kedelai: Lemak Sehat Penambah Kental ASI',
                'kategori_fase' => 'Ibu Menyusui',
                'kategori_kondisi' => 'Zat Gizi',
                'kandungan_gizi' => 'Asam Lemak Tak Jenuh, Vitamin E, Isoflavon, Protein Nabati',
                'saran_penggunaan' => 'Konsumsi segenggam kacang almond panggang tanpa garam sebagai camilan saat sesi menyusui atau memompa ASI di malam hari.',
                'deskripsi_manfaat' => 'Meningkatkan kandungan hindmilk (lemak kental di akhir sesi menyusui) yang berperan krusial dalam menaikkan berat badan bayi secara cepat.',
                'foto' => 'https://images.unsplash.com/photo-1508061252445-535e5f4335bb?auto=format&fit=crop&w=600&q=80',
                'created_by' => $adminId,
            ],
            [
                'nama_bahan_menu' => 'Sayur Bening Daun Kelor & Jagung Manis: Multivitamin Alami Ibu Menyusui',
                'kategori_fase' => 'Ibu Menyusui',
                'kategori_kondisi' => 'Edukasi Gizi',
                'kandungan_gizi' => 'Zat Besi 25x Bayam, Kalsium 4x Susu, Vitamin A & C',
                'saran_penggunaan' => 'Rebus daun kelor sebentar saja (jangan sampai terlalu layu) agar kandungan vitamin dan fitonutrien aktif tidak rusak.',
                'deskripsi_manfaat' => 'Daun kelor diakui WHO sebagai superfood untuk mencegah anemia ibu menyusui dan meningkatkan volume produksi ASI secara signifikan.',
                'foto' => 'https://images.unsplash.com/photo-1512621776951-a57141f2eefd?auto=format&fit=crop&w=600&q=80',
                'created_by' => $adminId,
            ],
            [
                'nama_bahan_menu' => 'Oatmeal Hangat, Biji Wijen & Pisang Raja: Serat Beta-Glukan & Kalori Tahan Lama',
                'kategori_fase' => 'Ibu Menyusui',
                'kategori_kondisi' => 'Zat Gizi',
                'kandungan_gizi' => 'Beta-Glukan, Kalium 450mg, Zat Besi, Karbohidrat Kompleks',
                'saran_penggunaan' => 'Sarapan penahan lapar yang sangat efektif bagi ibu yang menyusui langsung (direct breastfeeding). Biji wijen kaya akan kalsium nabati.',
                'deskripsi_manfaat' => 'Beta-glukan pada oat merangsang pelepasan hormon prolaktin yang membuat pabrik ASI ibu bekerja optimal sepanjang hari.',
                'foto' => 'https://images.unsplash.com/photo-1584365685547-9a5fb6f3a70c?auto=format&fit=crop&w=600&q=80',
                'created_by' => $adminId,
            ],

            // ==========================================
            // FASE 4: TUMBUH KEMBANG ANAK (6 ITEM MPASI & BALITA)
            // ==========================================
            [
                'nama_bahan_menu' => 'Bubur Tim Hati Ayam, Telur Puyuh & Labu Kuning: MPASI Emas Padat Gizi',
                'kategori_fase' => 'Tumbuh Kembang Anak',
                'kategori_kondisi' => 'Pencegahan Stunting',
                'kandungan_gizi' => 'Zat Besi Heme, Vitamin A, Protein Hewani 8g, Lemak Sehat',
                'saran_penggunaan' => 'Diberikan pada anak mulai usia 6 bulan ke atas sebagai MPASI utama. Tekstur disesuaikan bertahap (lumat halus ke cincang). Beri minyak kelapa atau santan untuk penyerapan vitamin.',
                'deskripsi_manfaat' => 'Kombinasi MPASI hati ayam dan telur puyuh merupakan senjata utama pencegah stunting nomor satu Kemenkes pada usia emas 6-23 bulan.',
                'foto' => 'https://images.unsplash.com/photo-1512621776951-a57141f2eefd?auto=format&fit=crop&w=600&q=80',
                'created_by' => $adminId,
            ],
            [
                'nama_bahan_menu' => 'Nasi Tim Ikan Salmon & Brokoli Cincang: MPASI Pengungkit Kecerdasan Otak',
                'kategori_fase' => 'Tumbuh Kembang Anak',
                'kategori_kondisi' => 'Makanan Bergizi',
                'kandungan_gizi' => 'Omega-3 DHA 800mg, Protein 15g, Kalsium 120mg, Serat',
                'saran_penggunaan' => 'Pilihan menu MPASI makan siang untuk balita usia 9-24 bulan. Tekstur empuk mudah dikunyah dan tidak amis jika dimasak dengan perasan jeruk nipis dan bawang putih.',
                'deskripsi_manfaat' => '80% perkembangan otak manusia terjadi pada usia MPASI 0-2 tahun. DHA salmon mempercepat maturasi sinaps saraf otak anak.',
                'foto' => 'https://images.unsplash.com/photo-1467003909585-2f8a72700288?auto=format&fit=crop&w=600&q=80',
                'created_by' => $adminId,
            ],
            [
                'nama_bahan_menu' => 'Sup Bola Daging Cincang & Wortel: MPASI Balita Belajar Kunyah & Otot Kuat',
                'kategori_fase' => 'Tumbuh Kembang Anak',
                'kategori_kondisi' => 'Makanan Bergizi',
                'kandungan_gizi' => 'Protein 16g, Zinc 4mg, Beta-Karoten, Kaldu Alami',
                'saran_penggunaan' => 'Bola daging cincang halus dicampur sedikit tepung tapioka dan wortel parut. Pilihan MPASI berkuah hangat saat anak sedang mogok makan (GTM) nasi.',
                'deskripsi_manfaat' => 'Kandungan zinc (seng) dalam olahan MPASI daging ini memacu pelepasan hormon pertumbuhan (GH) dan meningkatkan nafsu makan anak secara alami.',
                'foto' => 'https://images.unsplash.com/photo-1547592166-23ac45744acd?auto=format&fit=crop&w=600&q=80',
                'created_by' => $adminId,
            ],
            [
                'nama_bahan_menu' => 'Telur Orak-Arik Tahu Sutra & Tomat Segar: Sarapan MPASI Balita Praktis',
                'kategori_fase' => 'Tumbuh Kembang Anak',
                'kategori_kondisi' => 'Zat Gizi',
                'kandungan_gizi' => 'Kolin, Protein 12g, Likopen, Kalsium, Lemak Baik',
                'saran_penggunaan' => 'Menu sarapan MPASI kilat 5 menit yang kaya nutrisi. Tekstur sangat lembut sehingga anak tidak tersedak dan mudah dicerna usus balita.',
                'deskripsi_manfaat' => 'Kolin dari kuning telur menu MPASI ini mendukung fungsi daya ingat dan konsentrasi anak pada masa eksplorasi bermain.',
                'foto' => 'https://images.unsplash.com/photo-1582722872445-44dc5f7e3c8f?auto=format&fit=crop&w=600&q=80',
                'created_by' => $adminId,
            ],
            [
                'nama_bahan_menu' => 'Perkedel Daging Sapi & Kentang: Finger Food MPASI Padat Energi Atasi Picky Eater',
                'kategori_fase' => 'Tumbuh Kembang Anak',
                'kategori_kondisi' => 'Pencegahan Stunting',
                'kandungan_gizi' => 'Kalori 220 kkal, Protein Heme, Karbohidrat Kompleks, Zat Besi',
                'saran_penggunaan' => 'Bentuk seukuran genggaman tangan balita (finger food MPASI). Mengajarkan kemandirian makan sendiri (self-feeding) dan melatih koordinasi motorik tangan-mulut.',
                'deskripsi_manfaat' => 'Kepadatan energi tinggi per suapan MPASI sangat bermanfaat untuk mengejar ketertinggalan kurva berat badan anak (weight faltering).',
                'foto' => 'https://images.unsplash.com/photo-1546069901-ba9599a7e63c?auto=format&fit=crop&w=600&q=80',
                'created_by' => $adminId,
            ],
            [
                'nama_bahan_menu' => 'Puding Buah Naga & Susu UHT: Snack MPASI & Balita Kaya Serat & Kalsium',
                'kategori_fase' => 'Tumbuh Kembang Anak',
                'kategori_kondisi' => 'Edukasi Gizi',
                'kandungan_gizi' => 'Serat Alami, Kalsium 150mg, Antioksidan Betasianin, Vitamin B3',
                'saran_penggunaan' => 'Camilan selingan snack MPASI jam 10 pagi atau 4 sore. Warna ungu alami buah naga menarik perhatian balita tanpa pewarna sintetis.',
                'deskripsi_manfaat' => 'Mencegah susah buang air besar (konstipasi) pada anak MPASI dan menyumbang asupan kalsium harian untuk pemadatan tulang kaki anak.',
                'foto' => 'https://images.unsplash.com/photo-1488477181946-6428a0291777?auto=format&fit=crop&w=600&q=80',
                'created_by' => $adminId,
            ],
        ];

        // Kosongkan dan isi ulang dengan data lengkap terverifikasi
        InformasiNutrisi::truncate();

        foreach ($data as $item) {
            InformasiNutrisi::create($item);
        }
    }
}
