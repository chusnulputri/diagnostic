<?php

namespace App\Helpers;

use App\Models\dk_buku_besar;
use App\Models\dk_transactions;
use App\Models\m_company;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class Keuangan{
        
        public static function cek(){
            return 'Keuangan Ready';
        }

        public static function getTransaksi(String $default, int $company){
            $cek = dk_transactions::where('ju_default', $default)
                            ->where('ju_company_id', $company)
                            ->with('detail')->first();

            return $cek;
        }

        /*
        |--------------------------------------------------------------------------
        | List of function : 'saldo akun'
        |--------------------------------------------------------------------------
        |
        | Dibawah ini adalah kumpulan dari fungsi untuk mengatur saldo  
        | dari akun keuangan yang ada. Semua penjelasan dari masing fungsi sudah
        | dijelaskan didalam fungsi itu sendiri.
        |
        */
        
            public static function generateSaldoAwal(int $idAkun, int $idPerusahaan, float $saldo){
                /*
                | ------------------------------------------------------------------
                | Kegunaan fungsi ini.
                | ------------------------------------------------------------------ 
                |
                | Fungsi ini digunakan untuk menambahkan saldo awal dari akun coa 
                | yang baru atau memperbarui saldo awal dari coa yang sudah ada.
                |
                */

                $periodeAwal    = self::getPeriodePertama();

                if($periodeAwal == 'unknown'){
                    return [
                        'status'    => 'error',
                        'text'      => 'Perusahaan ini belum menentukan periode awal akuntansi. Segera hubungi developer untuk menyelesaikan masalah ini',
                        'err'       => 'App\Helpers\Keuangan.php on line 47'
                    ];
                }
                
                $cekSaldo       = DB::table('dk_akun_saldo')
                                        ->where('as_akun', $idAkun)
                                        ->where('as_perusahaan', $idPerusahaan)
                                        ->where('as_periode', $periodeAwal);

                if($cekSaldo->first()){
                    $saldoAwal  = $cekSaldo->first()->as_saldo_awal;
                    $selisih    = $saldoAwal - $saldo;

                    DB::table('dk_akun_saldo')
                            ->where('as_akun', $idAkun)
                            ->where('as_perusahaan', $idPerusahaan)->update([
                                'as_saldo_awal' => DB::raw('as_saldo_awal - '.$selisih),
                                'as_saldo_akhir' => DB::raw('as_saldo_akhir - '.$selisih),
                            ]);
                }else{
                    DB::table('dk_akun_saldo')->insert([
                        'as_akun'           => $idAkun,
                        'as_periode'        => $periodeAwal,
                        'as_perusahaan'     => $idPerusahaan,
                        'as_saldo_awal'     => $saldo,
                        'as_saldo_akhir'    => $saldo,
                    ]);
                }

                return [
                    'status'    => 'success',
                    'text'      => 'Saldo untuk akun terkait berhasil diperbarui',
                ];
            }

            public static function calculateSaldo(int $idAkun, int $level1, string $dk, float $value, int $company, string $tanggal, string $flag, string $status = null){
                /*
                | ------------------------------------------------------------------
                | Kegunaan fungsi ini.
                | ------------------------------------------------------------------ 
                |
                | Fungsi ini digunakan untuk mengkalkulasi saldo keuangan ketika 
                | terjadi transaksi pembukuan, untuk memastikan keseimbangan antara 
                | akun debet dan kredit pada keuangan peruahaan.
                |
                */

                $periode    = $tanggal; 
                $cek        = DB::table('dk_akun_saldo')
                                    ->where('as_periode', $periode)
                                    ->where('as_perusahaan', $company)
                                    ->where('as_akun', $idAkun);
                
                $in     = ($flag == 'in') ? $value : 0;
                $out    = ($flag == 'out') ? $value : 0;
                $mutasi = $in - $out;

                if($cek->first()){
                    
                    if($status == 'revert'){
                        $cek->update([
                            'as_mutasi_masuk'   => DB::raw('as_mutasi_masuk - '.$in),
                            'as_mutasi_keluar'  => DB::raw('as_mutasi_keluar - '.$out),
                            'as_saldo_akhir'    => DB::raw('as_saldo_akhir - '.$mutasi)
                        ]);
                    }else{
                        $cek->update([
                            'as_mutasi_masuk'   => DB::raw('as_mutasi_masuk + '.$in),
                            'as_mutasi_keluar'  => DB::raw('as_mutasi_keluar + '.$out),
                            'as_saldo_akhir'    => DB::raw('as_saldo_akhir + '.$mutasi)
                        ]);
                    }

                }else{
                    $lastSaldo      = DB::table('dk_akun_saldo')
                                        ->where('as_periode', '<', $periode)
                                        ->where('as_perusahaan', $company)
                                        ->where('as_akun', $idAkun)->orderBy('as_periode', 'desc')->first();

                    $lastSaldoAkhir  = ($lastSaldo) ? $lastSaldo->as_saldo_akhir : 0;

                    DB::table('dk_akun_saldo')->insert([
                        'as_akun'           => $idAkun,
                        'as_periode'        => $periode,
                        'as_perusahaan'     => $company,
                        'as_saldo_awal'     => $lastSaldoAkhir,
                        'as_mutasi_masuk'   => $in,
                        'as_mutasi_keluar'  => $out,
                        'as_saldo_akhir'    => $lastSaldoAkhir + $mutasi
                    ]);
                }

                // laba berjalan
                    if($level1 >= 4){
                        $flag      = ($dk == 'D') ? 'out' : 'in';
                        $saldoLaba = self::calculateLabaBerjalan($value, $company, $tanggal, $flag, $status);

                        if ($saldoLaba['status'] != 'success') {
                            return $saldoLaba;
                        }

                    }
                
                if($status == 'revert'){
                    DB::table('dk_akun_saldo')
                                ->where('as_periode', '>', $periode)
                                ->where('as_perusahaan', $company)
                                ->where('as_akun', $idAkun)->update([
                                    'as_saldo_awal'     => DB::raw('as_saldo_awal - '.$mutasi),
                                    'as_saldo_akhir'    => DB::raw('as_saldo_akhir - '.$mutasi),
                                ]);
                }else{
                    DB::table('dk_akun_saldo')
                                ->where('as_periode', '>', $periode)
                                ->where('as_perusahaan', $company)
                                ->where('as_akun', $idAkun)->update([
                                    'as_saldo_awal'     => DB::raw('as_saldo_awal + '.$mutasi),
                                    'as_saldo_akhir'    => DB::raw('as_saldo_akhir + '.$mutasi),
                                ]);
                }

                return [
                    'status'    => 'success',
                    'text'      => 'saldo berhasil di kalkulasi'
                ];
            }

            public static function calculateLabaBerjalan(float $value, int $company, string $tanggal, string $flag, string $status = null){
                /*
                | ------------------------------------------------------------------
                | Kegunaan fungsi ini.
                | ------------------------------------------------------------------ 
                |
                | Fungsi ini digunakan untuk mengkalkulasi saldo laba berjalan  
                | ketika terjadi transaksi pembukuan, untuk memastikan keseimbangan 
                | antara akun debet dan kredit pada keuangan peruahaan.
                |
                */

                $akunLaba = DB::table('dk_akun')->where('ak_default', 'laba berjalan')->where('ak_perusahaan', $company)->first();

                if($akunLaba){
                    $periode    = $tanggal; 
                    $cek        = DB::table('dk_akun_saldo')
                                        ->where('as_periode', $periode)
                                        ->where('as_perusahaan', $company)
                                        ->where('as_akun', $akunLaba->ak_id);
                    
                    $in     = ($flag == 'in') ? $value : 0;
                    $out    = ($flag == 'out') ? $value : 0;
                    $mutasi = $in - $out;
                }

                if($cek->first()){
                    
                    if($status == 'revert'){
                        $cek->update([
                            'as_mutasi_masuk'   => DB::raw('as_mutasi_masuk - '.$in),
                            'as_mutasi_keluar'  => DB::raw('as_mutasi_keluar - '.$out),
                            'as_saldo_akhir'    => DB::raw('as_saldo_akhir - '.$mutasi)
                        ]);
                    }else{
                        $cek->update([
                            'as_mutasi_masuk'   => DB::raw('as_mutasi_masuk + '.$in),
                            'as_mutasi_keluar'  => DB::raw('as_mutasi_keluar + '.$out),
                            'as_saldo_akhir'    => DB::raw('as_saldo_akhir + '.$mutasi)
                        ]);
                    }

                }else{
                    $lastSaldo      = DB::table('dk_akun_saldo')
                                        ->where('as_periode', '<', $periode)
                                        ->where('as_perusahaan', $company)
                                        ->where('as_akun', $akunLaba->ak_id)->orderBy('as_periode', 'desc')->first();

                    $lastSaldoAkhir  = ($lastSaldo) ? $lastSaldo->as_saldo_akhir : 0;

                    DB::table('dk_akun_saldo')->insert([
                        'as_akun'           => $akunLaba->ak_id,
                        'as_periode'        => $periode,
                        'as_perusahaan'     => $company,
                        'as_saldo_awal'     => $lastSaldoAkhir,
                        'as_mutasi_masuk'   => $in,
                        'as_mutasi_keluar'  => $out,
                        'as_saldo_akhir'    => $lastSaldoAkhir + $mutasi
                    ]);
                }


                if($status == 'revert'){
                    DB::table('dk_akun_saldo')
                                ->where('as_periode', '>', $periode)
                                ->where('as_perusahaan', $company)
                                ->where('as_akun', $akunLaba->ak_id)->update([
                                    'as_saldo_awal'     => DB::raw('as_saldo_awal - '.$mutasi),
                                    'as_saldo_akhir'    => DB::raw('as_saldo_akhir - '.$mutasi),
                                ]);
                }else{
                    DB::table('dk_akun_saldo')
                                ->where('as_periode', '>', $periode)
                                ->where('as_perusahaan', $company)
                                ->where('as_akun', $akunLaba->ak_id)->update([
                                    'as_saldo_awal'     => DB::raw('as_saldo_awal + '.$mutasi),
                                    'as_saldo_akhir'    => DB::raw('as_saldo_akhir + '.$mutasi),
                                ]);
                }

                return [
                    'status'    => 'success',
                    'text'      => 'saldo laba berjalan berhasil di kalkulasi'
                ];

            }


        /*
        |--------------------------------------------------------------------------
        | List of function : 'jurnal'
        |--------------------------------------------------------------------------
        |
        | Dibawah ini adalah kumpulan dari fungsi untuk mengatur data jurnal  
        | dari akun keuangan yang ada. Semua penjelasan dari masing fungsi sudah
        | dijelaskan didalam fungsi itu sendiri.
        |
        */
        
            public static function jurnal(array $detail, string $tanggal, int $company, int $idTransaksi, string $nomor, string $note = null, string $url = null, string $fitur = null){
                /*
                | ------------------------------------------------------------------
                | Kegunaan fungsi ini.
                | ------------------------------------------------------------------ 
                |
                | Fungsi ini digunakan untuk memasukkan data jurnal dari transaksi 
                | yang telah terjadi untuk kemudian dijadikan laporan keuangan.
                |
                */

                $periodeAwal = (self::getPeriodePertama() != 'unknown') ? self::getPeriodePertama() : 'unknown';
                
                if($tanggal < $periodeAwal || $periodeAwal == 'unknown'){
                    return [
                        'status'    => 'info',
                        'message'   => "Anda tidak bisa menambah transaksi yang terjadi sebelum tanggal '".$periodeAwal."'",
                        'err'       => 'App\Helpers\Keuangan.php on line 106',
                        'tgl'       => $tanggal.' '.$periodeAwal
                    ];
                }

                $tanggal = date('Y-m-d', strtotime($tanggal));

                $tahunTransaksi = date('Y', strtotime($tanggal));
                
                $cekTahun       = DB::table('dk_periode_keuangan')
                                        ->where('pk_periode', $tahunTransaksi)
                                        ->where('pk_company_id', $company)->first();

                if(!$cekTahun){
                    $tambahPeriode = self::addPeriode($tahunTransaksi, $company);

                    if ($tambahPeriode['status'] != 'success') {
                        return $tambahPeriode;
                    }
                }else if($cekTahun->pk_status == 'c'){
                    return [
                        'status'    => 'info',
                        'message'   => "Periode tahun '".$tahunTransaksi."' sudah ditutup. Anda tidak bisa menambahkan transaksi apapun di tahun tersebut",
                        'err'       => 'App\Helpers\Keuangan.php on line 126'
                    ];
                }

                $jurnalId = DB::table('dk_buku_besar')->insertGetId([
                    'bb_company_id'         => $company,
                    'bb_transaction_id'     => $idTransaksi,
                    'bb_nota_ref'           => $nomor,
                    'bb_url_ref'            => $url,
                    'bb_tanggal_transaksi'  => $tanggal,
                    'bb_note'               => $note,
                    'bb_fitur'              => $fitur,
                    'updated_by'            => Auth::user()->uc_user_id
                ]);

                $jurnalDetail = [];

                foreach($detail as $key => $dt){
                    $coa = DB::table('dk_akun')
                                ->where('ak_id', $dt['bbdt_coa'])
                                ->leftJoin('dk_hierarki_dua', 'hd_id', 'ak_kelompok')->first();

                    if(!$coa){
                        return [
                            'status'    => 'info',
                            'message'   => "Akun tidak bisa ditemukan. Akun tersebut dibutuhkan untuk pembukuan transaksi ini"
                        ];
                    }

                    $flag ='in';

                    if($coa->ak_posisi != $dt['bbdt_dk'])
                        $flag = 'out';

                    $triggerSaldoAkun = self::calculateSaldo(
                        $dt['bbdt_coa'], 
                        $coa->hd_level_1,
                        $dt['bbdt_dk'],
                        $dt['bbdt_value'], 
                        $company, 
                        $tanggal, 
                        $flag
                    );

                    if ($triggerSaldoAkun['status'] != 'success') {
                        return $triggerSaldoAkun;
                    }

                    array_push($jurnalDetail, [
                        'bbdt_buku_besar'   => $jurnalId,
                        'bbdt_coa'          => $dt['bbdt_coa'],
                        'bbdt_note'         => $dt['bbdt_note'],
                        'bbdt_value'        => $dt['bbdt_value'],
                        'bbdt_dk'           => $dt['bbdt_dk'],
                    ]);
                }

                DB::table('dk_buku_besar_detail')->insert($jurnalDetail);

                return [
                    'status'    => 'success',
                    'text'      => 'Jurnal berhasil di tambahkan.',
                ];
            }

            public static function dropJurnal(string $reff, int $company){
                /*
                | ------------------------------------------------------------------
                | Kegunaan fungsi ini.
                | ------------------------------------------------------------------ 
                |
                | Fungsi ini digunakan untuk memasukkan data jurnal dari transaksi 
                | yang telah terjadi untuk kemudian dijadikan laporan keuangan.
                |
                */

                $jurnal = dk_buku_besar::where('bb_nota_ref', 'like', '%'.$reff.'%')
                                    ->where('bb_company_id', $company)
                                    ->with([
                                        'detail' => function($query){
                                            $query->leftJoin('dk_akun', 'ak_id', 'bbdt_coa')
                                                    ->leftJoin('dk_hierarki_dua', 'hd_id', 'ak_kelompok')
                                                    ->select('dk_buku_besar_detail.*', 'ak_posisi', 'hd_level_1');
                                        }
                                    ]);

                foreach($jurnal->get() as $key => $data){
                    foreach($data->detail as $key => $detail){
                        
                        $flag = ($detail->bbdt_dk == $detail->ak_posisi) ? 'in' : 'out';

                        $dropSaldo = self::calculateSaldo(
                            $detail->bbdt_coa, 
                            $detail->hd_level_1, 
                            $detail->bbdt_dk, 
                            $detail->bbdt_value,
                            $data->bb_company_id,
                            $data->bb_tanggal_transaksi,
                            $flag,
                            'revert'
                        );

                        if ($dropSaldo['status'] != 'success') {
                            return $dropSaldo;
                        }
                    }
                }

                $jurnal->delete();

                return [
                    'status'    => 'success',
                    'text'      => 'Jurnal berhasil di drop.',
                ];
            }

        /*
        |--------------------------------------------------------------------------
        | List of function : 'periode keuangan
        |--------------------------------------------------------------------------
        |
        | Dibawah ini adalah kumpulan dari fungsi untuk mendapatkan informasi  
        | dari periode keuangan yang ada. Semua penjelasan dari masing fungsi sudah
        | dijelaskan didalam fungsi itu sendiri.
        |
        */
            public static function getPeriodePertama(){
                /*
                | ------------------------------------------------------------------
                | Kegunaan fungsi ini.
                | ------------------------------------------------------------------ 
                |
                | Fungsi ini digunakan untuk mengetahui periode pertama akuntansi 
                | milik perusahaan di sistem.
                |
                */
                $companyId = Auth::user()->uc_company_id;
                $cekCompany = m_company::where('c_id', $companyId)->first();
                if ($cekCompany->c_type == 'outlet') {
                    $companyId = $cekCompany->c_company_id;
                }

                $firstPeriode = DB::table('m_company')->where('c_id', $companyId)->select('c_first_period')->first();
                
                return ($firstPeriode && $firstPeriode->c_first_period) ? $firstPeriode->c_first_period : 'unknown';
            }
        
            public static function addPeriode(string $periode, int $company){
                /*
                | ------------------------------------------------------------------
                | Kegunaan fungsi ini.
                | ------------------------------------------------------------------ 
                |
                | Fungsi ini digunakan untuk menambahkan periode keuangan 
                | milik perusahaan.
                |
                */

                DB::table('dk_periode_keuangan')->insert([
                    'pk_company_id'     => $company,
                    'pk_periode'        => $periode
                ]);

                return [
                    'status'    => 'success',
                    'text'      => 'periode berhasil ditambahkan',
                ];
            }

    }
?>