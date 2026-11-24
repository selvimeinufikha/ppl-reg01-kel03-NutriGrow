<?php

namespace App\Services;

use Carbon\Carbon;

/**
 * PBI-017: Menghitung Umur dan Status Gizi Anak
 *
 * Service class untuk perhitungan otomatis:
 * 1. Umur anak saat pengukuran (dari tanggal lahir & tanggal ukur)
 * 2. Status gizi anak berdasarkan Permenkes No. 2 Tahun 2020
 *    yang mengacu pada standar WHO Child Growth Standards 2006
 *
 * Acceptance Criteria:
 * - Sistem menghitung umur saat pengukuran dari tanggal lahir dan tanggal ukur.
 * - Status gizi ditentukan otomatis mengacu Permenkes No. 2 Tahun 2020.
 */
class StatusGiziCalculator
{
    // =========================================================================
    // TABEL REFERENSI WHO 2006 — Median & SD (LMS Method)
    // Sumber: WHO Child Growth Standards, digunakan Permenkes No.2/2020
    // Kolom: usia_bulan => [median_bb, sd_bb, median_tb, sd_tb]
    // Berlaku untuk laki-laki; perempuan menggunakan tabel terpisah (simplifikasi)
    // =========================================================================

    /**
     * Tabel referensi BB/U (Berat Badan per Umur) — Laki-laki
     * Format: bulan => [median, -3SD, -2SD, -1SD, +1SD, +2SD, +3SD]
     */
    private static array $bbULakiLaki = [
        0  => [3.3, 2.1, 2.5, 2.9, 3.9, 4.4, 5.0],
        1  => [4.5, 2.9, 3.4, 3.9, 5.1, 5.8, 6.6],
        2  => [5.6, 3.8, 4.3, 4.9, 6.3, 7.1, 8.0],
        3  => [6.4, 4.4, 5.0, 5.7, 7.2, 8.0, 9.0],
        4  => [7.0, 4.9, 5.6, 6.2, 7.8, 8.7, 9.7],
        5  => [7.5, 5.3, 6.0, 6.7, 8.4, 9.3, 10.4],
        6  => [7.9, 5.7, 6.4, 7.1, 8.8, 9.8, 10.9],
        7  => [8.3, 6.0, 6.7, 7.4, 9.2, 10.3, 11.4],
        8  => [8.6, 6.3, 7.0, 7.7, 9.6, 10.7, 11.9],
        9  => [8.9, 6.6, 7.3, 8.0, 9.9, 11.0, 12.3],
        10 => [9.2, 6.8, 7.5, 8.3, 10.2, 11.4, 12.7],
        11 => [9.4, 7.1, 7.8, 8.6, 10.5, 11.7, 13.0],
        12 => [9.6, 7.1, 7.8, 8.6, 10.8, 12.0, 13.3],
        13 => [9.9, 7.3, 8.0, 8.9, 11.0, 12.3, 13.7],
        14 => [10.1, 7.5, 8.3, 9.1, 11.3, 12.6, 14.0],
        15 => [10.3, 7.7, 8.5, 9.3, 11.5, 12.8, 14.3],
        16 => [10.5, 7.8, 8.7, 9.5, 11.7, 13.1, 14.6],
        17 => [10.7, 8.0, 8.9, 9.7, 12.0, 13.4, 14.9],
        18 => [10.9, 8.1, 9.1, 9.9, 12.2, 13.7, 15.3],
        19 => [11.1, 8.3, 9.2, 10.1, 12.4, 13.9, 15.6],
        20 => [11.3, 8.5, 9.4, 10.3, 12.7, 14.2, 15.9],
        21 => [11.5, 8.6, 9.6, 10.5, 12.9, 14.5, 16.2],
        22 => [11.8, 8.8, 9.8, 10.7, 13.2, 14.8, 16.5],
        23 => [12.0, 9.0, 10.0, 10.9, 13.4, 15.1, 16.9],
        24 => [12.2, 9.2, 10.2, 11.2, 13.6, 15.3, 17.1],
        25 => [12.4, 9.4, 10.4, 11.4, 13.9, 15.6, 17.5],
        26 => [12.5, 9.5, 10.6, 11.6, 14.1, 15.8, 17.7],
        27 => [12.7, 9.7, 10.8, 11.8, 14.3, 16.1, 18.0],
        28 => [12.9, 9.9, 11.0, 12.0, 14.5, 16.3, 18.3],
        29 => [13.1, 10.0, 11.1, 12.2, 14.8, 16.6, 18.6],
        30 => [13.3, 10.2, 11.3, 12.4, 15.0, 16.9, 18.9],
        31 => [13.5, 10.3, 11.5, 12.6, 15.2, 17.1, 19.2],
        32 => [13.7, 10.5, 11.7, 12.8, 15.4, 17.4, 19.5],
        33 => [13.8, 10.7, 11.8, 13.0, 15.7, 17.6, 19.8],
        34 => [14.0, 10.8, 12.0, 13.2, 15.9, 17.9, 20.1],
        35 => [14.2, 11.0, 12.2, 13.4, 16.1, 18.2, 20.4],
        36 => [14.3, 11.2, 12.4, 13.6, 16.3, 18.4, 20.7],
        37 => [14.5, 11.3, 12.6, 13.8, 16.6, 18.7, 21.0],
        38 => [14.7, 11.5, 12.7, 14.0, 16.8, 18.9, 21.3],
        39 => [14.9, 11.6, 12.9, 14.2, 17.0, 19.2, 21.6],
        40 => [15.1, 11.8, 13.1, 14.4, 17.2, 19.4, 21.9],
        41 => [15.3, 12.0, 13.3, 14.6, 17.5, 19.7, 22.2],
        42 => [15.5, 12.1, 13.5, 14.8, 17.7, 20.0, 22.5],
        43 => [15.7, 12.3, 13.6, 15.0, 17.9, 20.2, 22.8],
        44 => [15.8, 12.4, 13.8, 15.2, 18.1, 20.5, 23.1],
        45 => [16.0, 12.6, 14.0, 15.4, 18.4, 20.7, 23.4],
        46 => [16.2, 12.7, 14.2, 15.6, 18.6, 21.0, 23.8],
        47 => [16.4, 12.9, 14.4, 15.8, 18.8, 21.3, 24.1],
        48 => [16.6, 13.1, 14.6, 16.0, 19.1, 21.5, 24.4],
        49 => [16.8, 13.2, 14.7, 16.2, 19.3, 21.8, 24.7],
        50 => [17.0, 13.4, 14.9, 16.4, 19.5, 22.1, 25.1],
        51 => [17.2, 13.5, 15.1, 16.6, 19.8, 22.4, 25.4],
        52 => [17.4, 13.7, 15.3, 16.8, 20.0, 22.6, 25.7],
        53 => [17.5, 13.8, 15.5, 17.1, 20.3, 22.9, 26.1],
        54 => [17.7, 14.0, 15.7, 17.3, 20.5, 23.2, 26.4],
        55 => [17.9, 14.2, 15.8, 17.5, 20.7, 23.5, 26.7],
        56 => [18.1, 14.3, 16.0, 17.7, 21.0, 23.8, 27.1],
        57 => [18.3, 14.5, 16.2, 17.9, 21.2, 24.0, 27.4],
        58 => [18.5, 14.6, 16.4, 18.1, 21.5, 24.3, 27.8],
        59 => [18.7, 14.8, 16.6, 18.3, 21.7, 24.6, 28.1],
        60 => [18.9, 15.0, 16.8, 18.5, 22.0, 24.9, 28.5],
    ];

    /**
     * Tabel referensi BB/U (Berat Badan per Umur) — Perempuan
     */
    private static array $bbUPerempuan = [
        0  => [3.2, 2.0, 2.4, 2.8, 3.7, 4.2, 4.8],
        1  => [4.2, 2.7, 3.2, 3.6, 4.8, 5.5, 6.2],
        2  => [5.1, 3.4, 3.9, 4.5, 5.8, 6.6, 7.5],
        3  => [5.8, 4.0, 4.5, 5.2, 6.6, 7.5, 8.5],
        4  => [6.4, 4.4, 5.0, 5.7, 7.3, 8.2, 9.3],
        5  => [6.9, 4.8, 5.4, 6.1, 7.8, 8.8, 10.0],
        6  => [7.3, 5.1, 5.7, 6.5, 8.2, 9.3, 10.6],
        7  => [7.6, 5.3, 6.0, 6.8, 8.6, 9.8, 11.1],
        8  => [7.9, 5.6, 6.3, 7.0, 9.0, 10.2, 11.6],
        9  => [8.2, 5.8, 6.5, 7.3, 9.3, 10.5, 12.0],
        10 => [8.5, 5.9, 6.7, 7.5, 9.6, 10.9, 12.4],
        11 => [8.7, 6.1, 6.9, 7.7, 9.9, 11.2, 12.8],
        12 => [8.9, 6.3, 7.0, 7.9, 10.1, 11.5, 13.1],
        13 => [9.2, 6.4, 7.2, 8.1, 10.4, 11.8, 13.5],
        14 => [9.4, 6.6, 7.4, 8.3, 10.6, 12.1, 13.8],
        15 => [9.6, 6.7, 7.6, 8.5, 10.9, 12.4, 14.1],
        16 => [9.8, 6.9, 7.7, 8.7, 11.1, 12.6, 14.5],
        17 => [10.0, 7.0, 7.9, 8.9, 11.4, 12.9, 14.8],
        18 => [10.2, 7.2, 8.1, 9.1, 11.6, 13.2, 15.1],
        19 => [10.4, 7.3, 8.2, 9.3, 11.8, 13.5, 15.4],
        20 => [10.6, 7.5, 8.4, 9.5, 12.1, 13.7, 15.7],
        21 => [10.9, 7.6, 8.6, 9.7, 12.3, 14.0, 16.0],
        22 => [11.1, 7.8, 8.7, 9.8, 12.5, 14.3, 16.4],
        23 => [11.3, 7.9, 8.9, 10.0, 12.8, 14.6, 16.7],
        24 => [11.5, 8.1, 9.0, 10.2, 13.0, 14.8, 17.0],
        25 => [11.7, 8.2, 9.2, 10.4, 13.2, 15.1, 17.3],
        26 => [11.9, 8.4, 9.4, 10.6, 13.5, 15.4, 17.7],
        27 => [12.1, 8.5, 9.6, 10.8, 13.7, 15.7, 18.0],
        28 => [12.3, 8.7, 9.7, 11.0, 14.0, 16.0, 18.4],
        29 => [12.5, 8.8, 9.9, 11.2, 14.2, 16.2, 18.7],
        30 => [12.7, 9.0, 10.1, 11.4, 14.4, 16.5, 19.0],
        31 => [12.9, 9.1, 10.3, 11.6, 14.7, 16.8, 19.4],
        32 => [13.1, 9.3, 10.4, 11.8, 14.9, 17.1, 19.7],
        33 => [13.3, 9.4, 10.6, 12.0, 15.2, 17.4, 20.1],
        34 => [13.5, 9.6, 10.8, 12.2, 15.4, 17.7, 20.4],
        35 => [13.7, 9.7, 10.9, 12.4, 15.7, 18.0, 20.8],
        36 => [13.9, 9.9, 11.1, 12.6, 15.9, 18.3, 21.2],
        37 => [14.1, 10.0, 11.3, 12.8, 16.2, 18.6, 21.5],
        38 => [14.3, 10.2, 11.5, 13.0, 16.4, 18.9, 21.9],
        39 => [14.5, 10.3, 11.6, 13.2, 16.7, 19.2, 22.3],
        40 => [14.7, 10.5, 11.8, 13.4, 16.9, 19.5, 22.7],
        41 => [14.9, 10.6, 12.0, 13.6, 17.2, 19.8, 23.1],
        42 => [15.1, 10.8, 12.2, 13.8, 17.4, 20.1, 23.5],
        43 => [15.3, 10.9, 12.4, 14.0, 17.7, 20.4, 23.9],
        44 => [15.5, 11.1, 12.6, 14.2, 18.0, 20.8, 24.3],
        45 => [15.7, 11.2, 12.7, 14.4, 18.2, 21.1, 24.7],
        46 => [16.0, 11.4, 12.9, 14.6, 18.5, 21.4, 25.1],
        47 => [16.2, 11.5, 13.1, 14.9, 18.8, 21.7, 25.5],
        48 => [16.4, 11.7, 13.3, 15.1, 19.0, 22.0, 25.9],
        49 => [16.6, 11.9, 13.5, 15.3, 19.3, 22.4, 26.3],
        50 => [16.8, 12.0, 13.7, 15.5, 19.6, 22.7, 26.7],
        51 => [17.1, 12.2, 13.9, 15.7, 19.9, 23.0, 27.2],
        52 => [17.3, 12.3, 14.1, 15.9, 20.2, 23.4, 27.6],
        53 => [17.5, 12.5, 14.3, 16.2, 20.5, 23.7, 28.1],
        54 => [17.8, 12.7, 14.5, 16.4, 20.8, 24.1, 28.5],
        55 => [18.0, 12.8, 14.7, 16.6, 21.1, 24.4, 29.0],
        56 => [18.2, 13.0, 14.9, 16.9, 21.4, 24.8, 29.5],
        57 => [18.5, 13.2, 15.1, 17.1, 21.7, 25.2, 29.9],
        58 => [18.7, 13.3, 15.3, 17.3, 22.0, 25.5, 30.4],
        59 => [18.9, 13.5, 15.5, 17.6, 22.3, 25.9, 30.9],
        60 => [19.2, 13.7, 15.8, 17.8, 22.6, 26.3, 31.3],
    ];

    /**
     * Tabel referensi PB/U atau TB/U (Tinggi Badan per Umur) — Laki-laki
     * Format: bulan => [median, -3SD, -2SD, -1SD, +1SD, +2SD, +3SD]
     */
    private static array $tbULakiLaki = [
        0  => [49.9, 44.2, 46.1, 48.0, 51.8, 53.7, 55.6],
        1  => [54.7, 49.0, 50.8, 52.8, 56.7, 58.6, 60.6],
        2  => [58.4, 52.4, 54.4, 56.4, 60.4, 62.4, 64.4],
        3  => [61.4, 55.3, 57.3, 59.4, 63.5, 65.5, 67.6],
        4  => [63.9, 57.6, 59.7, 61.8, 66.0, 68.0, 70.1],
        5  => [65.9, 59.6, 61.7, 63.8, 68.0, 70.1, 72.2],
        6  => [67.6, 61.2, 63.3, 65.5, 69.8, 71.9, 74.0],
        7  => [69.2, 62.7, 64.8, 67.0, 71.3, 73.5, 75.7],
        8  => [70.6, 64.0, 66.2, 68.4, 72.8, 75.0, 77.2],
        9  => [72.0, 65.2, 67.5, 69.7, 74.2, 76.5, 78.7],
        10 => [73.3, 66.4, 68.7, 71.0, 75.6, 77.9, 80.2],
        11 => [74.5, 67.6, 69.9, 72.2, 76.9, 79.2, 81.5],
        12 => [75.7, 68.6, 71.0, 73.4, 78.1, 80.5, 82.9],
        13 => [76.9, 69.6, 72.1, 74.5, 79.3, 81.8, 84.2],
        14 => [78.0, 70.6, 73.1, 75.6, 80.5, 83.0, 85.5],
        15 => [79.1, 71.6, 74.1, 76.6, 81.7, 84.2, 86.7],
        16 => [80.2, 72.5, 75.0, 77.6, 82.8, 85.4, 87.9],
        17 => [81.2, 73.3, 75.9, 78.6, 83.9, 86.5, 89.2],
        18 => [82.3, 74.0, 76.9, 79.6, 85.0, 87.7, 90.4],
        19 => [83.2, 74.9, 77.7, 80.6, 86.0, 88.8, 91.6],
        20 => [84.2, 75.7, 78.6, 81.5, 87.0, 89.9, 92.9],
        21 => [85.1, 76.5, 79.4, 82.3, 88.0, 91.0, 94.0],
        22 => [86.0, 77.2, 80.2, 83.2, 89.0, 92.0, 95.0],
        23 => [86.9, 78.0, 81.0, 84.0, 89.9, 93.0, 96.1],
        24 => [87.8, 78.7, 81.7, 84.9, 90.9, 94.0, 97.1],
        25 => [88.0, 80.0, 82.6, 85.4, 91.3, 94.2, 97.1],
        26 => [88.8, 80.8, 83.4, 86.3, 92.2, 95.1, 98.0],
        27 => [89.6, 81.5, 84.2, 87.1, 93.1, 96.1, 99.0],
        28 => [90.4, 82.3, 85.0, 87.9, 93.9, 97.0, 100.0],
        29 => [91.2, 83.0, 85.8, 88.7, 94.8, 97.9, 101.0],
        30 => [91.9, 83.7, 86.5, 89.5, 95.6, 98.7, 101.9],
        31 => [92.7, 84.4, 87.3, 90.3, 96.5, 99.6, 102.7],
        32 => [93.4, 85.1, 88.0, 91.1, 97.3, 100.4, 103.6],
        33 => [94.2, 85.8, 88.7, 91.9, 98.1, 101.3, 104.4],
        34 => [94.9, 86.5, 89.4, 92.6, 99.0, 102.1, 105.3],
        35 => [95.6, 87.1, 90.1, 93.4, 99.8, 103.0, 106.2],
        36 => [96.1, 87.4, 90.7, 94.0, 100.4, 103.7, 107.0],
        37 => [96.9, 88.1, 91.4, 94.7, 101.2, 104.5, 107.9],
        38 => [97.6, 88.7, 92.0, 95.4, 102.0, 105.4, 108.7],
        39 => [98.4, 89.3, 92.7, 96.1, 102.7, 106.2, 109.6],
        40 => [99.1, 89.9, 93.4, 96.8, 103.5, 107.0, 110.5],
        41 => [99.7, 90.5, 94.0, 97.5, 104.3, 107.8, 111.3],
        42 => [100.4, 91.1, 94.6, 98.2, 105.0, 108.6, 112.2],
        43 => [101.1, 91.7, 95.3, 98.8, 105.8, 109.4, 113.0],
        44 => [101.8, 92.3, 95.9, 99.5, 106.5, 110.2, 113.8],
        45 => [102.5, 92.8, 96.5, 100.2, 107.3, 111.0, 114.7],
        46 => [103.2, 93.4, 97.1, 100.8, 108.0, 111.8, 115.5],
        47 => [103.8, 94.0, 97.7, 101.5, 108.8, 112.6, 116.4],
        48 => [104.5, 94.5, 98.3, 102.2, 109.5, 113.4, 117.3],
        49 => [105.2, 95.1, 98.9, 102.8, 110.3, 114.2, 118.2],
        50 => [105.8, 95.7, 99.5, 103.5, 111.0, 115.0, 119.0],
        51 => [106.5, 96.2, 100.1, 104.1, 111.7, 115.7, 119.9],
        52 => [107.1, 96.8, 100.7, 104.8, 112.5, 116.5, 120.7],
        53 => [107.8, 97.3, 101.3, 105.4, 113.2, 117.3, 121.6],
        54 => [108.4, 97.8, 101.9, 106.1, 113.9, 118.1, 122.4],
        55 => [109.1, 98.3, 102.5, 106.7, 114.7, 118.9, 123.3],
        56 => [109.7, 98.9, 103.1, 107.4, 115.4, 119.7, 124.1],
        57 => [110.4, 99.4, 103.7, 108.0, 116.1, 120.4, 125.0],
        58 => [111.0, 99.9, 104.3, 108.7, 116.8, 121.2, 125.8],
        59 => [111.7, 100.4, 104.9, 109.3, 117.5, 122.0, 126.7],
        60 => [112.0, 100.7, 105.3, 110.0, 118.1, 122.7, 127.5],
    ];

    /**
     * Tabel referensi PB/U atau TB/U (Tinggi Badan per Umur) — Perempuan
     */
    private static array $tbUPerempuan = [
        0  => [49.1, 43.6, 45.4, 47.3, 51.0, 52.9, 54.7],
        1  => [53.7, 47.8, 49.8, 51.7, 55.6, 57.6, 59.5],
        2  => [57.1, 51.0, 53.0, 55.0, 59.1, 61.1, 63.2],
        3  => [59.8, 53.5, 55.6, 57.7, 61.9, 64.0, 66.1],
        4  => [62.1, 55.6, 57.8, 60.0, 64.3, 66.4, 68.6],
        5  => [64.0, 57.4, 59.6, 61.9, 66.2, 68.5, 70.7],
        6  => [65.7, 59.0, 61.2, 63.5, 68.0, 70.3, 72.5],
        7  => [67.3, 60.3, 62.7, 65.0, 69.6, 72.0, 74.4],
        8  => [68.7, 61.7, 64.0, 66.4, 71.1, 73.5, 75.9],
        9  => [70.1, 62.9, 65.3, 67.7, 72.6, 75.0, 77.4],
        10 => [71.5, 64.1, 66.5, 69.0, 74.0, 76.4, 78.9],
        11 => [72.8, 65.2, 67.7, 70.3, 75.3, 77.8, 80.3],
        12 => [74.0, 66.3, 68.9, 71.5, 76.6, 79.2, 81.7],
        13 => [75.2, 67.3, 70.0, 72.6, 77.8, 80.5, 83.1],
        14 => [76.4, 68.3, 71.0, 73.7, 79.1, 81.8, 84.5],
        15 => [77.5, 69.3, 72.0, 74.8, 80.2, 83.0, 85.9],
        16 => [78.6, 70.2, 73.0, 75.9, 81.4, 84.2, 87.1],
        17 => [79.7, 71.1, 74.0, 76.9, 82.5, 85.4, 88.4],
        18 => [80.7, 72.0, 74.9, 77.9, 83.6, 86.6, 89.7],
        19 => [81.7, 72.8, 75.8, 78.9, 84.7, 87.7, 90.8],
        20 => [82.7, 73.7, 76.7, 79.9, 85.7, 88.8, 91.9],
        21 => [83.7, 74.5, 77.5, 80.7, 86.7, 89.9, 93.1],
        22 => [84.6, 75.2, 78.4, 81.6, 87.7, 91.0, 94.3],
        23 => [85.5, 76.0, 79.2, 82.5, 88.7, 92.0, 95.4],
        24 => [86.4, 76.7, 80.0, 83.3, 89.7, 93.1, 96.5],
        25 => [87.4, 78.0, 81.0, 84.0, 90.7, 93.8, 96.9],
        26 => [88.3, 78.8, 81.8, 84.9, 91.7, 94.8, 97.9],
        27 => [89.1, 79.5, 82.6, 85.7, 92.6, 95.8, 99.0],
        28 => [89.9, 80.3, 83.3, 86.5, 93.5, 96.8, 100.1],
        29 => [90.7, 81.0, 84.1, 87.3, 94.5, 97.8, 101.1],
        30 => [91.5, 81.7, 84.9, 88.1, 95.4, 98.7, 102.1],
        31 => [92.4, 82.4, 85.6, 88.9, 96.3, 99.7, 103.1],
        32 => [93.2, 83.1, 86.4, 89.7, 97.2, 100.6, 104.1],
        33 => [94.0, 83.8, 87.1, 90.4, 98.1, 101.6, 105.1],
        34 => [94.7, 84.5, 87.8, 91.2, 99.0, 102.5, 106.1],
        35 => [95.5, 85.1, 88.6, 91.9, 99.9, 103.5, 107.0],
        36 => [96.1, 85.7, 89.1, 92.7, 100.6, 104.3, 108.0],
        37 => [96.9, 86.3, 89.9, 93.4, 101.5, 105.2, 109.0],
        38 => [97.6, 86.9, 90.6, 94.1, 102.4, 106.1, 110.0],
        39 => [98.4, 87.5, 91.3, 94.9, 103.2, 107.0, 110.9],
        40 => [99.1, 88.1, 92.0, 95.6, 104.1, 107.9, 111.9],
        41 => [99.9, 88.7, 92.7, 96.4, 104.9, 108.8, 112.8],
        42 => [100.6, 89.3, 93.4, 97.1, 105.8, 109.7, 113.8],
        43 => [101.4, 89.9, 94.1, 97.8, 106.7, 110.6, 114.7],
        44 => [102.1, 90.5, 94.8, 98.5, 107.5, 111.5, 115.7],
        45 => [102.9, 91.1, 95.5, 99.3, 108.4, 112.4, 116.6],
        46 => [103.6, 91.7, 96.2, 100.0, 109.2, 113.3, 117.5],
        47 => [104.3, 92.3, 96.9, 100.7, 110.1, 114.2, 118.5],
        48 => [105.0, 92.9, 97.6, 101.4, 111.0, 115.1, 119.4],
        49 => [105.8, 93.5, 98.3, 102.2, 111.8, 116.0, 120.4],
        50 => [106.5, 94.1, 99.0, 102.9, 112.7, 116.9, 121.4],
        51 => [107.2, 94.6, 99.7, 103.6, 113.5, 117.8, 122.3],
        52 => [107.9, 95.2, 100.3, 104.3, 114.4, 118.7, 123.3],
        53 => [108.7, 95.8, 101.0, 105.1, 115.2, 119.6, 124.3],
        54 => [109.4, 96.4, 101.7, 105.8, 116.1, 120.5, 125.2],
        55 => [110.1, 96.9, 102.3, 106.5, 117.0, 121.4, 126.2],
        56 => [110.8, 97.5, 103.0, 107.2, 117.8, 122.3, 127.2],
        57 => [111.5, 98.1, 103.7, 107.9, 118.7, 123.2, 128.1],
        58 => [112.2, 98.6, 104.3, 108.7, 119.5, 124.1, 129.1],
        59 => [112.9, 99.2, 105.0, 109.4, 120.4, 125.0, 130.1],
        60 => [113.6, 99.8, 105.7, 110.1, 121.2, 125.9, 131.0],
    ];

    // =========================================================================
    // PUBLIC METHODS
    // =========================================================================

    /**
     * Hitung umur anak dalam bulan dari tanggal lahir ke tanggal pengukuran.
     * PBI-017 Acceptance Criteria #1: Sistem menghitung umur saat pengukuran
     * dari tanggal lahir dan tanggal ukur.
     *
     * @param string $tanggalLahir  Format: YYYY-MM-DD
     * @param string $tanggalUkur   Format: YYYY-MM-DD
     * @return array ['bulan' => int, 'tahun' => int, 'sisa_bulan' => int, 'label' => string]
     */
    public static function hitungUmur(string $tanggalLahir, string $tanggalUkur): array
    {
        $lahir = Carbon::parse($tanggalLahir)->startOfDay();
        $ukur  = Carbon::parse($tanggalUkur)->startOfDay();

        $totalBulan = max(0, (int) $lahir->diffInMonths($ukur));
        $tahun      = (int) floor($totalBulan / 12);
        $sisaBulan  = $totalBulan % 12;

        // Label deskriptif
        if ($tahun === 0) {
            $label = "{$totalBulan} Bulan";
        } elseif ($sisaBulan === 0) {
            $label = "{$tahun} Tahun ({$totalBulan} Bulan)";
        } else {
            $label = "{$tahun} Tahun {$sisaBulan} Bulan ({$totalBulan} Bulan)";
        }

        return [
            'bulan'       => $totalBulan,
            'tahun'       => $tahun,
            'sisa_bulan'  => $sisaBulan,
            'label'       => $label,
        ];
    }

    /**
     * Hitung status gizi anak berdasarkan Permenkes No. 2 Tahun 2020.
     * PBI-017 Acceptance Criteria #2: Status gizi ditentukan otomatis
     * mengacu Permenkes No. 2 Tahun 2020.
     *
     * @param int    $usiaBulan    Usia anak dalam bulan
     * @param float  $beratBadan   Berat badan (kg)
     * @param float  $tinggiBadan  Tinggi/panjang badan (cm)
     * @param string $jenisKelamin 'Laki-Laki' atau 'Perempuan'
     * @return array Hasil kalkulasi lengkap dengan Z-score dan status
     */
    public static function hitungStatusGizi(
        int    $usiaBulan,
        float  $beratBadan,
        float  $tinggiBadan,
        string $jenisKelamin = 'Laki-Laki'
    ): array {
        $isLaki = stripos($jenisKelamin, 'laki') !== false;

        // Ambil tabel sesuai jenis kelamin
        $tabelBBU = $isLaki ? self::$bbULakiLaki : self::$bbUPerempuan;
        $tabelTBU = $isLaki ? self::$tbULakiLaki : self::$tbUPerempuan;

        // Batasi usia dalam rentang tabel (0-60 bulan)
        $usia = min(60, max(0, $usiaBulan));

        // ---- Z-Score BB/U (Berat Badan per Umur) ----
        $refBBU     = $tabelBBU[$usia] ?? $tabelBBU[60];
        $zScoreBBU  = self::hitungZScore($beratBadan, $refBBU);
        $statusBBU  = self::interpretasiBBU($zScoreBBU);

        // ---- Z-Score TB/U (Tinggi Badan per Umur) ----
        $refTBU     = $tabelTBU[$usia] ?? $tabelTBU[60];
        $zScoreTBU  = self::hitungZScore($tinggiBadan, $refTBU);
        $statusTBU  = self::interpretasiTBU($zScoreTBU);

        // ---- Penentuan Status Pertumbuhan Keseluruhan (Permenkes No.2/2020) ----
        $statusKeseluruhan = self::tentukanStatusKeseluruhan($zScoreBBU, $zScoreTBU);

        return [
            // Z-Score BB/U
            'z_score_bb_u'        => self::formatZScore($zScoreBBU),
            'z_score_bb_u_nilai'  => round($zScoreBBU, 2),
            'status_bb_u'         => $statusBBU['label'],
            'kategori_bb_u'       => $statusBBU['kategori'],

            // Z-Score TB/U
            'z_score_tb_u'        => self::formatZScore($zScoreTBU),
            'z_score_tb_u_nilai'  => round($zScoreTBU, 2),
            'status_tb_u'         => $statusTBU['label'],
            'kategori_tb_u'       => $statusTBU['kategori'],

            // Status keseluruhan
            'status_pertumbuhan'  => $statusKeseluruhan['label'],
            'status_type'         => $statusKeseluruhan['type'],
            'warna'               => $statusKeseluruhan['warna'],
            'rekomendasi'         => $statusKeseluruhan['rekomendasi'],

            // Referensi
            'referensi'           => 'Permenkes No. 2 Tahun 2020 & WHO Child Growth Standards 2006',
        ];
    }

    // =========================================================================
    // PRIVATE HELPER METHODS
    // =========================================================================

    /**
     * Hitung Z-Score menggunakan metode WHO LMS (simplifikasi linear interpolasi).
     * Format tabel: [median, -3SD, -2SD, -1SD, +1SD, +2SD, +3SD]
     */
    private static function hitungZScore(float $nilai, array $ref): float
    {
        [$median, $sd3neg, $sd2neg, $sd1neg, $sd1pos, $sd2pos, $sd3pos] = $ref;

        if ($nilai >= $median) {
            // Atas median: gunakan SD positif
            $sdUnit = ($sd1pos - $median);
        } else {
            // Bawah median: gunakan SD negatif
            $sdUnit = ($median - $sd1neg);
        }

        if ($sdUnit <= 0) {
            return 0.0;
        }

        return round(($nilai - $median) / $sdUnit, 2);
    }

    /**
     * Interpretasi Z-Score BB/U berdasarkan Permenkes No. 2 Tahun 2020.
     */
    private static function interpretasiBBU(float $z): array
    {
        if ($z < -3.0) {
            return ['kategori' => 'gizi_buruk',   'label' => 'Gizi Buruk (BB/U < -3 SD)'];
        } elseif ($z < -2.0) {
            return ['kategori' => 'gizi_kurang',  'label' => 'Gizi Kurang (BB/U -3 s/d -2 SD)'];
        } elseif ($z <= 2.0) {
            return ['kategori' => 'gizi_baik',    'label' => 'Gizi Baik (BB/U -2 s/d +2 SD)'];
        } else {
            return ['kategori' => 'risiko_lebih', 'label' => 'Risiko Gizi Lebih (BB/U > +2 SD)'];
        }
    }

    /**
     * Interpretasi Z-Score TB/U (PB/U) berdasarkan Permenkes No. 2 Tahun 2020.
     */
    private static function interpretasiTBU(float $z): array
    {
        if ($z < -3.0) {
            return ['kategori' => 'sangat_pendek', 'label' => 'Sangat Pendek / Stunting Berat (TB/U < -3 SD)'];
        } elseif ($z < -2.0) {
            return ['kategori' => 'pendek',        'label' => 'Pendek / Stunting (TB/U -3 s/d -2 SD)'];
        } elseif ($z <= 3.0) {
            return ['kategori' => 'normal',        'label' => 'Normal (TB/U -2 s/d +3 SD)'];
        } else {
            return ['kategori' => 'tinggi',        'label' => 'Tinggi (TB/U > +3 SD)'];
        }
    }

    /**
     * Tentukan status pertumbuhan keseluruhan sesuai prioritas Permenkes No. 2/2020.
     */
    private static function tentukanStatusKeseluruhan(float $zBBU, float $zTBU): array
    {
        // Urutan prioritas: Gizi Buruk > Stunting Berat > Gizi Kurang > Stunting > Normal > Risiko Lebih

        if ($zBBU < -3.0) {
            return [
                'type'       => 'danger',
                'warna'      => 'merah',
                'label'      => 'Gizi Buruk (Wasting Berat) — Perlu Rujukan Segera',
                'rekomendasi' => 'Rujuk ke fasilitas kesehatan tingkat lanjut. Berikan Therapeutic Feeding sesuai protokol Kemenkes.',
            ];
        }

        if ($zTBU < -3.0) {
            return [
                'type'       => 'danger',
                'warna'      => 'merah',
                'label'      => 'Sangat Pendek / Stunting Berat — Perlu Intervensi Segera',
                'rekomendasi' => 'Intervensi gizi intensif, stimulasi tumbuh kembang, dan rujukan ke dokter spesialis anak.',
            ];
        }

        if ($zBBU < -2.0 && $zTBU < -2.0) {
            return [
                'type'       => 'warning',
                'warna'      => 'orange',
                'label'      => 'Gizi Kurang & Stunting — Perlu Pantauan Intensif',
                'rekomendasi' => 'Program PMT (Pemberian Makanan Tambahan) berbasis protein hewani. Konseling gizi & kunjungan rumah setiap 2 minggu.',
            ];
        }

        if ($zBBU < -2.0) {
            return [
                'type'       => 'warning',
                'warna'      => 'kuning',
                'label'      => 'Gizi Kurang (Wasting) — Perlu Pantauan',
                'rekomendasi' => 'Tingkatkan asupan energi & protein hewani. PMT dan kunjungan ulang 1 bulan.',
            ];
        }

        if ($zTBU < -2.0) {
            return [
                'type'       => 'warning',
                'warna'      => 'kuning',
                'label'      => 'Pendek / Stunting — Perlu Pantauan',
                'rekomendasi' => 'Intervensi gizi sejak dini: ASI, MPASI bergizi, suplementasi zink & zat besi. Pantau setiap bulan.',
            ];
        }

        if ($zBBU > 2.0) {
            return [
                'type'       => 'info',
                'warna'      => 'biru',
                'label'      => 'Risiko Gizi Lebih — Pantau Pola Makan',
                'rekomendasi' => 'Kurangi asupan karbohidrat berlebih, perbanyak sayur & buah. Pantau setiap 3 bulan.',
            ];
        }

        return [
            'type'       => 'normal',
            'warna'      => 'hijau',
            'label'      => 'Pertumbuhan Baik & Normal',
            'rekomendasi' => 'Pertahankan asupan gizi seimbang, protein hewani (telur, ikan, daging), dan aktivitas fisik rutin.',
        ];
    }

    /**
     * Format Z-Score menjadi string yang mudah dibaca.
     */
    private static function formatZScore(float $z): string
    {
        $sign   = $z >= 0 ? '+' : '';
        $nilai  = number_format($z, 1);
        return "{$sign}{$nilai} SD";
    }
}

