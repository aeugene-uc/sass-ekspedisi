<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        DB::table('perusahaan')->insert([
            ['id' => 1, 'nama' => 'Logistik Nusantara Express', 'logo' => 'logo_ln_express.png'],
            ['id' => 2, 'nama' => 'Cargo Kilat Indonesia', 'logo' => 'logo_cki.png']
        ]);

        DB::table('otorisasi')->insert([
            ['id' => 1, 'nama' => 'manage_dashboard'],
            ['id' => 2, 'nama' => 'manage_orders'],
            ['id' => 3, 'nama' => 'view_reports'],
            ['id' => 4, 'nama' => 'driver_app_access'],
        ]);

        DB::table('peran_users')->insert([
            ['id' => 1, 'nama' => 'Super Admin', 'is_platform_admin' => true, 'perusahaan_id' => null],
            ['id' => 2, 'nama' => 'Admin Operasional', 'is_platform_admin' => false, 'perusahaan_id' => 1],
            ['id' => 3, 'nama' => 'Kurir Driver', 'is_platform_admin' => false, 'perusahaan_id' => 1],
            ['id' => 4, 'nama' => 'Customer', 'is_platform_admin' => false, 'perusahaan_id' => null]
        ]);

        DB::table('peran_user_otorisasi')->insert([
            ['peran_id' => 1, 'otorisasi_id' => 1],
            ['peran_id' => 1, 'otorisasi_id' => 2],
            ['peran_id' => 2, 'otorisasi_id' => 2],
            ['peran_id' => 3, 'otorisasi_id' => 4],
        ]);

        DB::table('users')->insert([
            ['id' => 1, 'full_name' => 'Budi Santoso', 'email' => 'superadmin@platform.com', 'password' => Hash::make('password123'), 'peran_id' => 1],
            ['id' => 2, 'full_name' => 'Siti Aminah', 'email' => 'admin@logistiknusantara.com', 'password' => Hash::make('password123'), 'peran_id' => 2],
            ['id' => 3, 'full_name' => 'Joko Widodo', 'email' => 'driver01@logistiknusantara.com', 'password' => Hash::make('password123'), 'peran_id' => 3],
            ['id' => 4, 'full_name' => 'Rina Customer', 'email' => 'rina@gmail.com', 'password' => Hash::make('password123'), 'peran_id' => 4],
        ]);

        DB::table('metode_asal_pengiriman')->insert([
            ['id' => 1, 'nama' => 'Dropoff di Counter'],
            ['id' => 2, 'nama' => 'Pick Up Kurir'],
        ]);

        DB::table('metode_destinasi_pengiriman')->insert([
            ['id' => 1, 'nama' => 'Ambil di Counter'],
            ['id' => 2, 'nama' => 'Diantar ke Alamat'],
        ]);

        DB::table('status_pesanan')->insert([
            ['id' => 1, 'status' => 'Menunggu Pembayaran'],
            ['id' => 2, 'status' => 'Barang Diperiksa'],
            ['id' => 3, 'status' => 'Dalam Pengiriman'],
            ['id' => 4, 'status' => 'Selesai'],
            ['id' => 5, 'status' => 'Dibatalkan'],
        ]);

        DB::table('kasus')->insert([
            ['id' => 1, 'kasus' => 'Barang Rusak Saat Diterima'],
            ['id' => 2, 'kasus' => 'Alamat Tidak Ditemukan'],
            ['id' => 3, 'kasus' => 'Penerima Menolak Barang'],
        ]);

        DB::table('jangkauan')->insert([
            ['id' => 1, 'nama' => 'Jabodetabek'],
            ['id' => 2, 'nama' => 'Jawa-Bali'],
            ['id' => 3, 'nama' => 'Nasional'],
        ]);

        DB::table('jenis_kendaraan')->insert([
            ['id' => 1, 'jenis' => 'Motor'],
            ['id' => 2, 'jenis' => 'Blind Van'],
            ['id' => 3, 'jenis' => 'Truk Engkel'],
        ]);

        DB::table('kendaraan')->insert([
            ['id' => 1, 'plat_nomor' => 'B 1234 SJA', 'operasional' => true, 'jenis_kendaraan_id' => 2],
            ['id' => 2, 'plat_nomor' => 'B 9988 XYZ', 'operasional' => true, 'jenis_kendaraan_id' => 1]
        ]);

        DB::table('counters')->insert([
            ['id' => 1, 'perusahaan_id' => 1, 'alamat' => 'Jl. Sudirman No. 45, Jakarta Pusat', 'lat' => -6.2088, 'lng' => 106.8456],
            ['id' => 2, 'perusahaan_id' => 1, 'alamat' => 'Jl. Dago No. 10, Bandung', 'lat' => -6.9175, 'lng' => 107.6191]
        ]);

        DB::table('layanan')->insert([
            ['id' => 1, 'nama' => 'Regular Economy', 'gambar' => 'service_reg.jpg', 'model_harga' => 'FLAT_RATE', 'perusahaan_id' => 1],
            ['id' => 2, 'nama' => 'Next Day Prime', 'gambar' => 'service_next.jpg', 'model_harga' => 'DISTANCE_BASED', 'perusahaan_id' => 1]
        ]);

        DB::table('layanan_jangkauan')->insert([
            ['layanan_id' => 1, 'jangkauan_id' => 3],
            ['layanan_id' => 2, 'jangkauan_id' => 1],
        ]);

        DB::table('layanan_metode_pengiriman')->insert([
            ['layanan_id' => 1, 'metode_asal_pengiriman_id' => 1, 'metode_destinasi_pengiriman_id' => 2],
            ['layanan_id' => 2, 'metode_asal_pengiriman_id' => 2, 'metode_destinasi_pengiriman_id' => 2],
        ]);

        DB::table('daftar_muat')->insert([
            ['id' => 1, 'tanggal_dibuat' => '2023-10-25', 'tanggal_selesai' => null, 'counter_asal_id' => 1, 'kendaraan_id' => 1]
        ]);

        DB::table('kurir_daftar_muat')->insert([
            ['daftar_muat_id' => 1, 'kurir_id' => 3]
        ]);

        DB::table('pesanan')->insert([
            ['id' => 1001, 'tarif' => 50000, 'tanggal_pemesanan' => '2023-10-25', 'tanggal_terkirim' => null, 'foto_terkirim' => null, 'daftar_muat_id' => 1, 'user_id' => 4, 'metode_destinasi_pengiriman_id' => 2, 'metode_asal_pengiriman_id' => 1, 'lat_asal' => -6.2088, 'lng_asal' => 106.8456, 'alamat_asal' => 'Counter Jakarta Pusat', 'lat_destinasi' => -6.2200, 'lng_destinasi' => 106.8500, 'alamat_destinasi' => 'Apartemen Kuningan Lt 5', 'status_id' => 3],
            ['id' => 1002, 'tarif' => 15000, 'tanggal_pemesanan' => '2023-10-26', 'tanggal_terkirim' => null, 'foto_terkirim' => null, 'daftar_muat_id' => null, 'user_id' => 4, 'metode_destinasi_pengiriman_id' => 2, 'metode_asal_pengiriman_id' => 2, 'lat_asal' => -6.2100, 'lng_asal' => 106.8200, 'alamat_asal' => 'Kantor Rina, Sudirman', 'lat_destinasi' => -6.3000, 'lng_destinasi' => 106.9000, 'alamat_destinasi' => 'Rumah Orang Tua, Bekasi', 'status_id' => 1]
        ]);

        DB::table('barang')->insert([
            ['id' => 1, 'pesanan_id' => 1001, 'foto' => 'img_paket_1001.jpg', 'berat_g' => 2500.00, 'panjang_cm' => 30.00, 'lebar_cm' => 20.00, 'tinggi_cm' => 15.00],
            ['id' => 2, 'pesanan_id' => 1002, 'foto' => 'img_paket_1002.jpg', 'berat_g' => 500.00, 'panjang_cm' => 10.00, 'lebar_cm' => 10.00, 'tinggi_cm' => 5.00]
        ]);

        DB::table('buku_kasus')->insert([
            ['id' => 1, 'pesanan_id' => 1001, 'kasus_id' => 2, 'selesai' => false]
        ]);
    }
}
