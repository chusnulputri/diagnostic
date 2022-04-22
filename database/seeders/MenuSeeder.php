<?php

namespace Database\Seeders;

use App\Models\app_features;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class MenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $menuLevel = [

            // Manajemen Cabang
            ["name" => "Manajemen Cabang Perushaan", "level" => "0"],
            ["name" => "Manajemen Cabang Perushaan ", "level" => "1"],
            ["name" => "Akses Menu", "level" => "2", "permission_slug" => "master-entity-menu"],
            ["name" => "Tambah Data", "level" => "2", "permission_slug" => "master-entity-create"],
            ["name" => "Edit Data", "level" => "2", "permission_slug" => "master-entity-update"],
            ["name" => "Hapus Data", "level" => "2", "permission_slug" => "master-entity-delete"],
            

            ["name" => "Data Master", "level" => "0"],
            // Master Divisi
            ["name" => "Data Divisi", "level" => "1"],
            ["name" => "Akses Menu", "level" => "2", "permission_slug" => "master-division-menu"],
            // ["name" => "Akses Data", "level" => "2", "permission_slug" => "master-division-read"],
            ["name" => "Tambah Data", "level" => "2", "permission_slug" => "master-division-create"],
            ["name" => "Edit Data", "level" => "2", "permission_slug" => "master-division-update"],
            ["name" => "Hapus Data", "level" => "2", "permission_slug" => "master-division-delete"],
            // Master Data Jabatan
            ["name" => "Data Jabatan", "level" => "1"],
            ["name" => "Akses Menu", "level" => "2", "permission_slug" => "master-position-menu"],
            // ["name" => "Akses Data", "level" => "2", "permission_slug" => "master-position-read"],
            ["name" => "Tambah Data", "level" => "2", "permission_slug" => "master-position-create"],
            ["name" => "Edit Data", "level" => "2", "permission_slug" => "master-position-update"],
            ["name" => "Hapus Data", "level" => "2", "permission_slug" => "master-position-delete"],
            // Master Data Pegawai
            ["name" => "Data Pegawai", "level" => "1"],
            ["name" => "Akses Menu", "level" => "2", "permission_slug" => "master-employee-menu"],
            // ["name" => "Akses Data", "level" => "2", "permission_slug" => "master-employee-read"],
            ["name" => "Tambah Data", "level" => "2", "permission_slug" => "master-employee-create"],
            ["name" => "Edit Data", "level" => "2", "permission_slug" => "master-employee-update"],
            ["name" => "Hapus Data", "level" => "2", "permission_slug" => "master-employee-delete"],
            // Master Customer
            ["name" => "Data Customer", "level" => "1"],
            ["name" => "Akses Menu", "level" => "2", "permission_slug" => "master-customer-menu"],
            // ["name" => "Akses Data", "level" => "2", "permission_slug" => "master-customer-read"],
            ["name" => "Tambah Data", "level" => "2", "permission_slug" => "master-customer-create"],
            ["name" => "Edit Data", "level" => "2", "permission_slug" => "master-customer-update"],
            ["name" => "Hapus Data", "level" => "2", "permission_slug" => "master-customer-delete"],
            // Master Supplier
            ["name" => "Data Supplier", "level" => "1"],
            ["name" => "Akses Menu", "level" => "2", "permission_slug" => "master-supplier-menu"],
            // ["name" => "Akses Data", "level" => "2", "permission_slug" => "master-supplier-read"],
            ["name" => "Tambah Data", "level" => "2", "permission_slug" => "master-supplier-create"],
            ["name" => "Edit Data", "level" => "2", "permission_slug" => "master-supplier-update"],
            ["name" => "Hapus Data", "level" => "2", "permission_slug" => "master-supplier-delete"],
            // Master Outlet
            ["name" => "Data Outlet", "level" => "1"],
            ["name" => "Akses Menu", "level" => "2", "permission_slug" => "master-outlet-menu"],
            // ["name" => "Akses Data", "level" => "2", "permission_slug" => "master-outlet-read"],
            ["name" => "Tambah Data", "level" => "2", "permission_slug" => "master-outlet-create"],
            ["name" => "Edit Data", "level" => "2", "permission_slug" => "master-outlet-update"],
            ["name" => "Hapus Data", "level" => "2", "permission_slug" => "master-outlet-delete"],
            // Master Item
            ["name" => "Data Item & Harga", "level" => "1"],
            ["name" => "Akses Menu", "level" => "2", "permission_slug" => "master-item-menu"],
            // ["name" => "Akses Data", "level" => "2", "permission_slug" => "master-item-read"],
            ["name" => "Tambah Data", "level" => "2", "permission_slug" => "master-item-create"],
            ["name" => "Edit Data", "level" => "2", "permission_slug" => "master-item-update"],
            ["name" => "Hapus Data", "level" => "2", "permission_slug" => "master-item-delete"],
            // Master Resep
            ["name" => "Data Resep", "level" => "1"],
            ["name" => "Akses Menu", "level" => "2", "permission_slug" => "master-item-recipe-menu"],
            // ["name" => "Akses Data", "level" => "2", "permission_slug" => "master-item-recipe-read"],
            ["name" => "Tambah Data", "level" => "2", "permission_slug" => "master-item-recipe-create"],
            ["name" => "Edit Data", "level" => "2", "permission_slug" => "master-item-recipe-update"],
            ["name" => "Hapus Data", "level" => "2", "permission_slug" => "master-item-recipe-delete"],
            // Master Akun Perkiraan
            ["name" => "Data Akun Perkiraan", "level" => "1"],
            ["name" => "Akses Menu", "level" => "2", "permission_slug" => "master-coa-menu"],
            // ["name" => "Akses Data", "level" => "2", "permission_slug" => "master-coa-read"],
            ["name" => "Tambah Data", "level" => "2", "permission_slug" => "master-coa-create"],
            ["name" => "Edit Data", "level" => "2", "permission_slug" => "master-coa-update"],
            ["name" => "Hapus Data", "level" => "2", "permission_slug" => "master-coa-delete"],
            // Data Transaksi
            ["name" => "Data Transaksi", "level" => "1"],
            ["name" => "Akses Menu", "level" => "2", "permission_slug" => "master-transaction-menu"],
            // ["name" => "Akses Data", "level" => "2", "permission_slug" => "master-transaction-read"],
            ["name" => "Tambah Data", "level" => "2", "permission_slug" => "master-transaction-create"],
            ["name" => "Edit Data", "level" => "2", "permission_slug" => "master-transaction-update"],
            ["name" => "Hapus Data", "level" => "2", "permission_slug" => "master-transaction-delete"],
            // Master Pemabayaran
            ["name" => "Data Pembayaran", "level" => "1"],
            ["name" => "Akses Menu", "level" => "2", "permission_slug" => "master-payment-method-menu"],
            // ["name" => "Akses Data", "level" => "2", "permission_slug" => "master-payment-method-read"],
            ["name" => "Tambah Data", "level" => "2", "permission_slug" => "master-payment-method-create"],
            ["name" => "Edit Data", "level" => "2", "permission_slug" => "master-payment-method-update"],
            ["name" => "Hapus Data", "level" => "2", "permission_slug" => "master-payment-method-delete"],
            // Master Lokasi Presensi
            ["name" => "Data Lokasi Presensi", "level" => "1"],
            ["name" => "Akses Menu", "level" => "2", "permission_slug" => "master-presence-location-menu"],
            // ["name" => "Akses Data", "level" => "2", "permission_slug" => "master-presence-location-read"],
            ["name" => "Tambah Data", "level" => "2", "permission_slug" => "master-presence-location-create"],
            ["name" => "Edit Data", "level" => "2", "permission_slug" => "master-presence-location-update"],
            ["name" => "Hapus Data", "level" => "2", "permission_slug" => "master-presence-location-delete"],

            // Master Biaya Sewa
            ["name" => "Data Biaya Sewa", "level" => "1"],
            ["name" => "Akses Menu", "level" => "2", "permission_slug" => "master-subscription-plan-menu"],
            // ["name" => "Akses Data", "level" => "2", "permission_slug" => "master-subscription-plan-read"],
            ["name" => "Tambah Data", "level" => "2", "permission_slug" => "master-subscription-plan-create"],
            ["name" => "Edit Data", "level" => "2", "permission_slug" => "master-subscription-plan-update"],
            ["name" => "Hapus Data", "level" => "2", "permission_slug" => "master-subscription-plan-delete"],
            
            // Menu
            // Aktivitas pembelian
            ["name" => "Aktivitas Pembelian", "level" => "0"],
            // Pemesanan Pembelian
            ["name" => "Pemesanan Pembelian", "level" => "1"],
            ["name" => "Akses Menu", "level" => "2", "permission_slug" => "purchase-order-menu"],
            // ["name" => "Akses Data", "level" => "2", "permission_slug" => "purchase-order-read"],
            ["name" => "Tambah Data", "level" => "2", "permission_slug" => "purchase-order-create"],
            ["name" => "Edit Data", "level" => "2", "permission_slug" => "purchase-order-update"],
            ["name" => "Proses Data", "level" => "2", "permission_slug" => "purchase-order-process"],
            ["name" => "Batal Data", "level" => "2", "permission_slug" => "purchase-order-cancel"],
            ["name" => "konfirmasi Order", "level" => "2", "permission_slug" => "purchase-order-confirm-ordered"],
            ["name" => "Batal Order", "level" => "2", "permission_slug" => "purchase-order-cancel-ordered"],
            ["name" => "Konifirmasi Approval 1", "level" => "2", "permission_slug" => "purchase-order-confirm-approval-1"],
            ["name" => "Konifirmasi Approval 2", "level" => "2", "permission_slug" => "purchase-order-confirm-approval-1"],
            ["name" => "Hapus Data", "level" => "2", "permission_slug" => "purchase-order-delete"],
            // Penerimaan Barang
            ["name" => "Penerimaan Barang", "level" => "1"],
            ["name" => "Akses Menu", "level" => "2", "permission_slug" => "purchase-delivery-menu"],
            // ["name" => "Akses Data", "level" => "2", "permission_slug" => "purchase-delivery-read"],
            ["name" => "Tambah Data", "level" => "2", "permission_slug" => "purchase-delivery-create"],
            ["name" => "Edit Data", "level" => "2", "permission_slug" => "purchase-delivery-update"],
            ["name" => "Konifirmasi Penerimaan", "level" => "2", "permission_slug" => "purchase-delivery-confirm-received"],
            ["name" => "Batal Penerimaan", "level" => "2", "permission_slug" => "purchase-delivery-cancel-received"],
            ["name" => "Hapus Data", "level" => "2", "permission_slug" => "purchase-delivery-delete"],
            // Return Pembelian
            ["name" => "Retur Pembelian", "level" => "1"],
            ["name" => "Akses Menu", "level" => "2", "permission_slug" => "purchase-return-menu"],
            // ["name" => "Akses Data", "level" => "2", "permission_slug" => "purchase-return-read"],
            ["name" => "Tambah Data", "level" => "2", "permission_slug" => "purchase-return-create"],
            ["name" => "Edit Data", "level" => "2", "permission_slug" => "purchase-return-update"],
            ["name" => "Hapus Data", "level" => "2", "permission_slug" => "purchase-return-delete"],
            // 
            // Aktivitas Gudang
            ["name" => "Aktivitas Gudang", "level" => "0"],
            // Manajemen Barang Masuk
            ["name" => "Manajemen Barang Masuk", "level" => "1"],
            ["name" => "Akses Menu", "level" => "2", "permission_slug" => "incoming-goods-menu"],
            // ["name" => "Akses Data", "level" => "2", "permission_slug" => "incoming-goods-read"],
            ["name" => "Tambah Data", "level" => "2", "permission_slug" => "incoming-goods-create"],
            ["name" => "Edit Data", "level" => "2", "permission_slug" => "incoming-goods-update"],
            ["name" => "Approval 1", "level" => "2", "permission_slug" => "incoming-goods-confirm-approval-1"],
            ["name" => "Approval 2", "level" => "2", "permission_slug" => "incoming-goods-confirm-approval-2"],
            ["name" => "Approval 3 ", "level" => "2", "permission_slug" => "incoming-goods-confirm-approval-3"],
            ["name" => "Batal Approval 1", "level" => "2", "permission_slug" => "incoming-goods-cancel-approval-1"],
            ["name" => "Batal Approval 2", "level" => "2", "permission_slug" => "incoming-goods-cancel-approval-2"],
            ["name" => "Batal Approval 3 ", "level" => "2", "permission_slug" => "incoming-goods-cancel-approval-3"],
            ["name" => "Hapus Data", "level" => "2", "permission_slug" => "incoming-goods-delete"],
            // Barang Keluar
            ["name" => "Manajemen Barang Keluar", "level" => "1"],
            ["name" => "Akses Menu", "level" => "2", "permission_slug" => "outgoing-goods-menu"],
            // ["name" => "Akses Data", "level" => "2", "permission_slug" => "outgoing-goods-read"],
            ["name" => "Tambah Data", "level" => "2", "permission_slug" => "outgoing-goods-create"],
            ["name" => "Edit Data", "level" => "2", "permission_slug" => "outgoing-goods-update"],
            ["name" => "Approval 1", "level" => "2", "permission_slug" => "outgoing-goods-confirm-approval-1"],
            ["name" => "Approval 2", "level" => "2", "permission_slug" => "outgoing-goods-confirm-approval-2"],
            ["name" => "Approval 3 ", "level" => "2", "permission_slug" => "outgoing-goods-confirm-approval-3"],
            ["name" => "Batal Approval 1", "level" => "2", "permission_slug" => "outgoing-goods-cancel-approval-1"],
            ["name" => "Batal Approval 2", "level" => "2", "permission_slug" => "outgoing-goods-cancel-approval-2"],
            ["name" => "Batal Approval 3 ", "level" => "2", "permission_slug" => "outgoing-goods-cancel-approval-3"],
            ["name" => "Hapus Data", "level" => "2", "permission_slug" => "outgoing-goods-delete"],
            // Opname
            ["name" => "Input Opname Stok", "level" => "1"],
            ["name" => "Akses Menu", "level" => "2", "permission_slug" => "opname-menu"],
            // ["name" => "Akses Data", "level" => "2", "permission_slug" => "opname-read"],
            ["name" => "Tambah Data", "level" => "2", "permission_slug" => "opname-create"],
            ["name" => "Edit Data", "level" => "2", "permission_slug" => "opname-update"],
            ["name" => "adjustment", "level" => "2", "permission_slug" => "opname-delete"],
            ["name" => "Hapus Data", "level" => "2", "permission_slug" => "opname-adjustment"],
            // Laporan Stok
            ["name" => "Laporan Stok", "level" => "1"],
            ["name" => "Akses Menu", "level" => "2", "permission_slug" => "stock-monitoring-menu"],
            // ["name" => "Akses Data", "level" => "2", "permission_slug" => "stock-monitoring-read"],
            // Pengiriman Packaging
            ["name" => "Pengiriman Packaging", "level" => "1"],
            ["name" => "Akses Menu", "level" => "2", "permission_slug" => "extra-stock-transfer-menu"],
            // ["name" => "Akses Data", "level" => "2", "permission_slug" => "extra-stock-transfer-read"],
            ["name" => "Tambah Data", "level" => "2", "permission_slug" => "extra-stock-transfer-create"],
            ["name" => "Hapus Data", "level" => "2", "permission_slug" => "extra-stock-transfer-delete"],
            // Return Packaging
            // ["name" => "Return Packaging", "level" => "1"],

            // Aktivitas Produksi
            ["name" => "Aktivitas Produksi", "level" => "0"],
            // Rencana Produksi
            ["name" => "Rencana Produksi Harian", "level" => "1"],
            ["name" => "Akses Menu", "level" => "2", "permission_slug" => "production-plan-menu"],
            // ["name" => "Akses Data", "level" => "2", "permission_slug" => "production-plan-read"],
            ["name" => "Tambah Data", "level" => "2", "permission_slug" => "production-plan-create"],
            ["name" => "Konfirmasi Data", "level" => "2", "permission_slug" => "production-plan-confirm"],
            ["name" => "Batal Data", "level" => "2", "permission_slug" => "production-plan-cancel"],
            ["name" => "Hapus Data", "level" => "2", "permission_slug" => "production-plan-delete"],
            // Penggunaan Bahan baku
            ["name" => "Penggunaan Bahan Baku", "level" => "1"],
            ["name" => "Akses Menu", "level" => "2", "permission_slug" => "production-raw-menu"],
            // ["name" => "Akses Data", "level" => "2", "permission_slug" => "production-raw-read"],
            ["name" => "Tambah Data", "level" => "2", "permission_slug" => "production-raw-create"],
            ["name" => "Konfirmasi", "level" => "2", "permission_slug" => "production-raw-confirm-submit"],
            ["name" => "Batal Konfirmasi", "level" => "2", "permission_slug" => "production-raw-cancel-submit"],
            ["name" => "Approval 1", "level" => "2", "permission_slug" => "production-raw-confirm-approval-1"],
            ["name" => "Approval 2", "level" => "2", "permission_slug" => "production-raw-confirm-approval-2"],
            ["name" => "Hapus Data", "level" => "2", "permission_slug" => "production-raw-delete"],
            // Manajamen Hasil Produksi
            ["name" => "Manajemen Hasil Produksi", "level" => "1"],
            ["name" => "Akses Menu", "level" => "2", "permission_slug" => "production-finished-menu"],
            // ["name" => "Akses Data", "level" => "2", "permission_slug" => "production-finished-read"],
            ["name" => "Tambah Data", "level" => "2", "permission_slug" => "production-finished-create"],
            ["name" => "Konfirmasi Data", "level" => "2", "permission_slug" => "production-finished-confirm"],
            ["name" => "Batal Data", "level" => "2", "permission_slug" => "production-finished-cancel"],
            ["name" => "Hapus Data", "level" => "2", "permission_slug" => "production-finished-delete"],
            // Manajamen Produk Waste
            ["name" => "Manajemen Produk Waste", "level" => "1"],
            ["name" => "Akses Menu", "level" => "2", "permission_slug" => "production-waste-menu"],
            // ["name" => "Akses Data", "level" => "2", "permission_slug" => "production-waste-read"],
            ["name" => "Tambah Data", "level" => "2", "permission_slug" => "production-waste-create"],
            ["name" => "Edit Data", "level" => "2", "permission_slug" => "production-waste-update"],
            ["name" => "Hapus Data", "level" => "2", "permission_slug" => "production-waste-delete"],
            ["name" => "Konfirmasi Data", "level" => "2", "permission_slug" => "production-waste-confirm"],
            // Laporan Produksi
            ["name" => "Laporan Produksi", "level" => "1"],
            ["name" => "Akses Menu", "level" => "2", "permission_slug" => "production-report-read"],

            // Aktivitas Penjualan
            ["name" => "Aktivitas Penjualan", "level" => "0"],
            // Penjualan Produk
            ["name" => "Penjualan Produk", "level" => "1"],
            ["name" => "Akses Menu", "level" => "2", "permission_slug" => "sales-order-menu"],
            // ["name" => "Akses Data", "level" => "2", "permission_slug" => "sales-order-read"],
            ["name" => "Tambah Data", "level" => "2", "permission_slug" => "sales-order-create"],
            ["name" => "Konfirmasi Data", "level" => "2", "permission_slug" => "sales-order-confirm"],
            ["name" => "Batal Data", "level" => "2", "permission_slug" => "sales-order-cancel"],
            ["name" => "Hapus Data", "level" => "2", "permission_slug" => "sales-order-delete"],
            // Pengiriman Penjualan
            ["name" => "Pengiriman Penjualan", "level" => "1"],
            ["name" => "Akses Menu", "level" => "2", "permission_slug" => "sales-delivery-menu"],
            // ["name" => "Akses Data", "level" => "2", "permission_slug" => "sales-delivery-read"],
            ["name" => "Konfirmasi Data", "level" => "2", "permission_slug" => "sales-delivery-confirm-sent"],
            ["name" => "Batal Data", "level" => "2", "permission_slug" => "sales-delivery-cancel-sent"],
            // Laporan Penjualan
            ["name" => "Laporan Penjualan", "level" => "1"],
            ["name" => "Akses Menu", "level" => "2", "permission_slug" => "sales-report-menu"],
            // ["name" => "Akses Data", "level" => "2", "permission_slug" => "sales-report-read"],
            // Return Penjualan
            ["name" => "Retur Penjualan", "level" => "1"],
            ["name" => "Akses Menu", "level" => "2", "permission_slug" => "sales-return-menu"],
            ["name" => "Tambah Data", "level" => "2", "permission_slug" => "sales-return-create"],
            ["name" => "Edit Data", "level" => "2", "permission_slug" => "sales-return-update"],
            ["name" => "Hapus Data", "level" => "2", "permission_slug" => "sales-return-delete"],

            // Aktivitas Outlet
            ["name" => "Aktivitas Outlet", "level" => "0"],
            // Laporan Penjualan Harian 
            ["name" => "Laporan Penjualan Harian", "level" => "1"],
            ["name" => "Akses Menu", "level" => "2", "permission_slug" => "sales-report-menu"],
            // ["name" => "Akses Data", "level" => "2", "permission_slug" => "sales-report-read"],
            // Manajemen Setoran Outlet
            ["name" => "Manajemen Setoran Outlet", "level" => "1"],
            ["name" => "Akses Menu", "level" => "2", "permission_slug" => "sales-deposit-menu"],
            // ["name" => "Akses Data", "level" => "2", "permission_slug" => "sales-deposit-read"],
            ["name" => "Tambah Data", "level" => "2", "permission_slug" => "sales-deposit-create"],
            ["name" => "Edit Data", "level" => "2", "permission_slug" => "sales-deposit-update"],
            ["name" => "Konfirmasi Data", "level" => "2", "permission_slug" => "sales-deposit-confirm-received"],
            ["name" => "Hapus Data", "level" => "2", "permission_slug" => "sales-deposit-delete"],
            // Manajemen Uang Kembalian
            ["name" => "Manajemen Uang Kembalian", "level" => "1"],
            ["name" => "Akses Menu", "level" => "2", "permission_slug" => "sales-change-money-menu"],
            // ["name" => "Akses Data", "level" => "2", "permission_slug" => "sales-change-money-read"],
            ["name" => "Tambah Data", "level" => "2", "permission_slug" => "sales-change-money-create"],
            ["name" => "Edit Data", "level" => "2", "permission_slug" => "sales-change-money-update"],
            ["name" => "Konfirmasi Pemberian", "level" => "2", "permission_slug" => "sales-change-money-confirm-handed"],
            ["name" => "Konfirmasi Penerimaan", "level" => "2", "permission_slug" => "sales-change-money-confirm-received"],
            ["name" => "Hapus Data", "level" => "2", "permission_slug" => "sales-change-money-delete"],
            // SDM

            ["name" => "Aktivitas SDM", "level" => "0"],
            // Attendance
            ["name" => "Daftar Presensi Karyawan", "level" => "1"],
            ["name" => "Akses Menu", "level" => "2", "permission_slug" => "sdm-attendance-menu"],
            ["name" => "Tambah Data", "level" => "2", "permission_slug" => "sdm-attendance-create-absent"],

            // ["name" => "Aturan Kehadiran", "level" => "1"],
            // Workdays & Holiday
            ["name" => "Kelola Hari Kerja & Libur", "level" => "1"],
            ["name" => "Akses Menu", "level" => "2", "permission_slug" => "sdm-workdays-menu"],
            ["name" => "Tambah Data Hari Libur", "level" => "2", "permission_slug" => "sdm-workdays-holidays-create"],
            ["name" => "Edit Data Hari Libur", "level" => "2", "permission_slug" => "sdm-workdays-holidays-update"],
            ["name" => "Hapus Data Hari Libur", "level" => "2", "permission_slug" => "sdm-workdays-holidays-delete"],
            // ["name" => "Tambah Data Hari Kerja", "level" => "2", "permission_slug" => "sdm-attendance-create-absent"],
            ["name" => "Edit Data Hari Kerja", "level" => "2", "permission_slug" => "sdm-workdays-management-update"],
            // Permintaan Lembur
            ["name" => "Kelola Permintaan Lembur", "level" => "1"],
            ["name" => "Akses Menu", "level" => "2", "permission_slug" => "sdm-overtime-menu"],
            ["name" => "Tambah Data", "level" => "2", "permission_slug" => "sdm-overtime-create"],
            ["name" => "Edit Data", "level" => "2", "permission_slug" => "sdm-overtime-update"],
            ["name" => "Hapus Data", "level" => "2", "permission_slug" => "sdm-overtime-delete"],
            // Leave Management
            ["name" => "Kelola Cuti Kerja", "level" => "1"],
            ["name" => "Akses Menu", "level" => "2", "permission_slug" => "sdm-leave-management-menu"],
            ["name" => "Tambah Data", "level" => "2", "permission_slug" => "sdm-leave-management-create"],
            ["name" => "Edit Data", "level" => "2", "permission_slug" => "sdm-leave-management-update"],
            ["name" => "Approval Manajer", "level" => "2", "permission_slug" => "sdm-leave-management-approval-1"],
            // ["name" => "Konfirmasi Penerimaan", "level" => "2", "permission_slug" => "sales-change-money-confirm-received"],
            ["name" => "Hapus Data", "level" => "2", "permission_slug" => "sdm-leave-management-delete"],
            // Cashbon Management 
            ["name" => "Kelola Cashbon Karyawan", "level" => "1"],
            ["name" => "Akses Menu", "level" => "2", "permission_slug" => "sdm-cashbon-management-menu"],
            ["name" => "Tambah Data", "level" => "2", "permission_slug" => "sdm-cashbon-management-create"],
            ["name" => "Edit Data", "level" => "2", "permission_slug" => "sdm-cashbon-management-update"],
            ["name" => "Approval Manajer", "level" => "2", "permission_slug" => "sdm-cashbon-management-approval-1"],
            ["name" => "Hapus Data", "level" => "2", "permission_slug" => "sdm-cashbon-management-delete"],
            // Schedule Cashbon
            ["name" => "Kelola Jadwal Cashbon", "level" => "1"],
            ["name" => "Akses Menu", "level" => "2", "permission_slug" => "sdm-cashbon-schedule-menu"],
            ["name" => "Tambah Data", "level" => "2", "permission_slug" => "sdm-cashbon-schedule-create"],
            ["name" => "Edit Data", "level" => "2", "permission_slug" => "sdm-cashbon-schedule-update"],
            ["name" => "Hapus Data", "level" => "2", "permission_slug" => "sdm-cashbon-schedule-delete"],
            // Employee Loan
            ["name" => "Input Data Pinjaman", "level" => "1"],
            ["name" => "Akses Menu", "level" => "2", "permission_slug" => "sdm-employee-loan-menu"],
            ["name" => "Tambah Data", "level" => "2", "permission_slug" => "sdm-employee-loan-create"],
            ["name" => "Edit Data", "level" => "2", "permission_slug" => "sdm-employee-loan-update"],
            ["name" => "Hapus Data", "level" => "2", "permission_slug" => "sdm-employee-loan-delete"],
            ["name" => "Konfirmasi Pemberian", "level" => "2", "permission_slug" => "sdm-employee-loan-confirm-release"],
            // Sallary Management
            ["name" => "Kelola Gaji Karyawan", "level" => "1"],
            ["name" => "Akses Menu", "level" => "2", "permission_slug" => "sdm-sallary-management-menu"],
            ["name" => "Tambah Data", "level" => "2", "permission_slug" => "sdm-sallary-management-create"],
            ["name" => "Edit Data", "level" => "2", "permission_slug" => "sdm-sallary-management-update"],
            ["name" => "Hapus Data", "level" => "2", "permission_slug" => "sdm-sallary-management-delete"],
            ["name" => "Konfirmasi Pemberian", "level" => "2", "permission_slug" => "sdm-sallary-management-confirm-release"],
            // Management Sallary Bonus
            ["name" => "Kelola Bonus", "level" => "1"],
            ["name" => "Akses Menu", "level" => "2", "permission_slug" => "sdm-sallary-bonus-menu"],
            ["name" => "Tambah Data", "level" => "2", "permission_slug" => "sdm-sallary-bonus-create"],
            ["name" => "Edit Data", "level" => "2", "permission_slug" => "sdm-sallary-bonus-update"],
            ["name" => "Hapus Data", "level" => "2", "permission_slug" => "sdm-sallary-bonus-delete"],
            ["name" => "Konfirmasi Pemberian", "level" => "2", "permission_slug" => "sdm-sallary-bonus-confirm-received"],
            ["name" => "Batal Pemberian", "level" => "2", "permission_slug" => "sdm-sallary-bonus-cancel-received"],
            // Sallary Punishment
            ["name" => "Punishment/potongan", "level" => "1"],
            ["name" => "Akses Menu", "level" => "2", "permission_slug" => "sdm-sallary-cuts-menu"],
            ["name" => "Tambah Data", "level" => "2", "permission_slug" => "sdm-sallary-cuts-create"],
            ["name" => "Edit Data", "level" => "2", "permission_slug" => "sdm-sallary-cuts-update"],
            ["name" => "Hapus Data", "level" => "2", "permission_slug" => "sdm-sallary-cuts-delete"],
            ["name" => "Konfirmasi Pemberian", "level" => "2", "permission_slug" => "sdm-sallary-cuts-confirm-received"],
            ["name" => "Batal Pemberian", "level" => "2", "permission_slug" => "sdm-sallary-cuts-cancel-received"],
            // Sallary Allowance
            ["name" => "Tunjangan Pegawai", "level" => "1"],
            ["name" => "Akses Menu", "level" => "2", "permission_slug" => "sdm-sallary-allowance-menu"],
            ["name" => "Tambah Data", "level" => "2", "permission_slug" => "sdm-sallary-allowance-create"],
            ["name" => "Edit Data", "level" => "2", "permission_slug" => "sdm-sallary-allowance-update"],
            ["name" => "Hapus Data", "level" => "2", "permission_slug" => "sdm-sallary-allowance-delete"],
            ["name" => "Konfirmasi Pemberian", "level" => "2", "permission_slug" => "sdm-sallary-allowance-confirm-received"],
            ["name" => "Batal Pemberian", "level" => "2", "permission_slug" => "sdm-sallary-allowance-cancel-received"],
            // Management Resign
            ["name" => "Kelola Data Resign", "level" => "1"],
            ["name" => "Akses Menu", "level" => "2", "permission_slug" => "sdm-resign-management-menu"],
            ["name" => "Tambah Data", "level" => "2", "permission_slug" => "sdm-resign-management-create"],
            ["name" => "Edit Data", "level" => "2", "permission_slug" => "sdm-resign-management-update"],
            ["name" => "Hapus Data", "level" => "2", "permission_slug" => "sdm-resign-management-delete"],
            ["name" => "Konfirmasi", "level" => "2", "permission_slug" => "sdm-resign-management-confirm"],
            ["name" => "Batal Konfirmasi", "level" => "2", "permission_slug" => "sdm-resign-management-cancel"],
            ["name" => "Approval Manajer", "level" => "2", "permission_slug" => "sdm-resign-management-approval-1"],
            ["name" => "Approval Direktur", "level" => "2", "permission_slug" => "sdm-resign-management-approval-2"],
            // Job Vacancy Management
            ["name" => "Kelola Kebutuhan SDM", "level" => "1"],
            ["name" => "Akses Menu", "level" => "2", "permission_slug" => "sdm-job-vacancy-menu"],
            ["name" => "Tambah Data", "level" => "2", "permission_slug" => "sdm-job-vacancy-create"],
            ["name" => "Edit Data", "level" => "2", "permission_slug" => "sdm-job-vacancy-update"],
            ["name" => "Hapus Data", "level" => "2", "permission_slug" => "sdm-job-vacancy-delete"],
            ["name" => "Publish", "level" => "2", "permission_slug" => "sdm-job-vacancy-publish"],
            ["name" => "Batal Publish", "level" => "2", "permission_slug" => "sdm-job-vacancy-cancel-publish"],
            // Job Applicant
            ["name" => "Prosedur Calon SDM", "level" => "1"],
            ["name" => "Akses Menu", "level" => "2", "permission_slug" => "sdm-job-applicants-menu"],
            ["name" => "Approval", "level" => "2", "permission_slug" => "sdm-job-applicants-approve"],
            // Quiz Management
            ["name" => "Kelola Master Kuis", "level" => "1"],
            ["name" => "Akses Menu", "level" => "2", "permission_slug" => "sdm-quiz-management-menu"],
            ["name" => "Tambah Data", "level" => "2", "permission_slug" => "sdm-quiz-management-create"],
            ["name" => "Edit Data", "level" => "2", "permission_slug" => "sdm-quiz-management-update"],
            ["name" => "Hapus Data", "level" => "2", "permission_slug" => "sdm-quiz-management-delete"],
            ["name" => "Perbarui Status", "level" => "2", "permission_slug" => "sdm-quiz-management-update-status"],
            // Job Test Schedule
            ["name" => "Kelola Jadwal Ujian", "level" => "1"],
            ["name" => "Akses Menu", "level" => "2", "permission_slug" => "sdm-job-test-schedule-menu"],
            ["name" => "Tambah Data", "level" => "2", "permission_slug" => "sdm-job-test-schedule-create"],
            ["name" => "Edit Data", "level" => "2", "permission_slug" => "sdm-job-test-schedule-update"],
            ["name" => "Hapus Data", "level" => "2", "permission_slug" => "sdm-job-test-schedule-delete"],
            ["name" => "Penetapan Test", "level" => "2", "permission_slug" => "sdm-job-test-schedule-assign-quiz"],
            ["name" => "Kirim Notifikasi", "level" => "2", "permission_slug" => "sdm-job-test-schedule-send-notif"],
            // Management Result Test
            ["name" => "Kelola Hasil Ujian", "level" => "1"],
            ["name" => "Akses Menu", "level" => "2", "permission_slug" => "sdm-job-applicant-test-result-menu"],
            ["name" => "Penilaian Hasil Test", "level" => "2", "permission_slug" => "sdm-job-applicant-test-result-confirm-1"],
            // Management Result Interview
            ["name" => "Kelola Hasil Interview", "level" => "1"],
            ["name" => "Akses Menu", "level" => "2", "permission_slug" => "sdm-job-applicant-interview-menu"],
            ["name" => "Penilaian Hasil Interview", "level" => "2", "permission_slug" => "sdm-job-applicant-interview-confirm"],
            // Management Employee Mutation
            ["name" => "Mutasi Karyawan", "level" => "1"],
            ["name" => "Akses Menu", "level" => "2", "permission_slug" => "sdm-employee-mutation-menu"],
            ["name" => "Tambah Data", "level" => "2", "permission_slug" => "sdm-employee-mutation-create"],
            ["name" => "Hapus Data", "level" => "2", "permission_slug" => "sdm-employee-mutation-delete"],
            ["name" => "Approval", "level" => "2", "permission_slug" => "sdm-employee-mutation-confirm"],

            // Aktivitas Delivery
            ["name" => "Aktivitas Delivery", "level" => "0"],
            // Petugas Delivery
            ["name" => "Petugas Delivery", "level" => "1"],
            ["name" => "Akses Menu", "level" => "2", "permission_slug" => "delivery-courier-menu"],
            ["name" => "Edit Data", "level" => "2", "permission_slug" => "delivery-courier-update"],
            // Penjadwalan Delivery
            ["name" => "Penjadwalan Delivery", "level" => "1"],
            ["name" => "Akses Menu", "level" => "2", "permission_slug" => "delivery-schedule-menu"],

            // Aktivitas Aset
            ["name" => "Aktivitas Aset", "level" => "0"],
            // Pengelola Aset
            ["name" => "Pengelolaan Aset", "level" => "1"],
            // ["name" => "Aktivitas Keuangan", "level" => "0"],
            // ["name" => "Input Transaksi Kas/bank", "level" => "1"],
            // ["name" => "Input Transaksi Jurnal", "level" => "1"],
            // ["name" => "Approve Purchase Order", "level" => "1"],
            // ["name" => "Invoicing", "level" => "1"],
            // ["name" => "Penerimaan Pembayaran", "level" => "1"],
            // ["name" => "Pembayaran Hutang", "level" => "1"],
            // ["name" => "Data Lapporan Keuangan", "level" => "1"],
            // ["name" => "Data Analisa Keuangan", "level" => "1"],
            // ["name" => "Aktivitas Direktur", "level" => "0"],
            // ["name" => "Manajemen Approval", "level" => "1"],
            // ["name" => "Laporan Keuangan", "level" => "1"],
            // ["name" => "Laporan Pembelian", "level" => "1"],
            // ["name" => "Laporan Penjualan", "level" => "1"],
            // ["name" => "Laporan Stok", "level" => "1"],
            // ["name" => "Laporan Hasil Produksi", "level" => "1"],
            // ["name" => "Pengaturan Aplikasi", "level" => "0"],
            // ["name" => "Backup Database", "level" => "1"],
            // ["name" => "Akses Pengguna", "level" => "1"],

            // Mobile
            ["name" => "Aplikasi Mobile", "level" => "0"],
            // Mobile
            ["name" => "Aplikasi Mobile ", "level" => "1"],
            // Mobile
            ["name" => "Akses Aplikasi Mobile", "level" => "2", "permission_slug" => "mobile-permissions"],

        ];
        $parentIdLevel0 = '';
        $parentIdLevel1 = '';
        Schema::disableForeignKeyConstraints();
        app_features::query()->truncate();
        Schema::enableForeignKeyConstraints();
        foreach ($menuLevel as $key => $value) {
            if ($value['level'] == 0) {
                $newMenu = new app_features();
                $newMenu->name = $value['name'];
                $newMenu->save();
                $parentIdLevel0 = $newMenu->id;
            } else if ($value['level'] == 1) {
                $newMenu = new app_features();
                $newMenu->name = $value['name'];
                $newMenu->parent_id = $parentIdLevel0;
                $newMenu->save();
                $parentIdLevel1 = $newMenu->id;
            } else if ($value['level'] == 2) {
                $newMenu = new app_features();
                $newMenu->name = $value['name'];
                $newMenu->parent_id = $parentIdLevel1;
                $newMenu->permission_slug = $value['permission_slug'] ?? null;
                $newMenu->save();
            }
        }
    }
}
