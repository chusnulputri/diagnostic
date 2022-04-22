<?php
    namespace App\Helpers;

    use DB;
    use Auth;

    class App{

        public static function generateKode($table, $id_kolom, $nomor_kolom, $kolom_tanggal, $kolom_holding , $holding, $kolom_perusahaan , $perusahaan, $announcer , $tanggal, $id){
            /*
            | ------------------------------------------------------------------
            | Kegunaan fungsi ini.
            | ------------------------------------------------------------------ 
            |
            | Fungsi ini digunakan untuk membuat nomor data sesuai dengan kolom 
            | dan diurutkan sesuai dengan bulan data tersebut dimasukkan
            |
            */

            $day = date('d', strtotime($tanggal));
            $mY = date('my', strtotime($tanggal));
    
            if($id){
                $cek = DB::table($table)->where($id_kolom, $id)->first();
    
                if($cek && (date('m-Y', strtotime($tanggal)) == date('m-Y', strtotime($cek->$kolom_tanggal)))){
                    return $announcer.'-'.$holding.$perusahaan.'.'.$mY.'.'.explode('.', $cek->$nomor_kolom)[2];
                }
            }
    
            $search = DB::table($table)
                ->where(DB::raw('DATE_FORMAT('.$kolom_tanggal.', "%m%y")'), $mY);
                
            if($kolom_holding)
                $search = $search->where($kolom_holding, $holding);
    
            if($kolom_perusahaan)
                $search = $search->where($kolom_perusahaan, $perusahaan);
            
                $search = $search->orderBy($id_kolom, 'desc')
                            ->select($nomor_kolom, $kolom_tanggal)
                            ->first();
    
            if(!$search){
                $counter = 1;
            }else{
                $counter  = (int) explode('.', $search->$nomor_kolom)[2] + 1;
            }
    
            return $announcer.'-'.$holding.$perusahaan.'.'.$mY.'.'.str_pad( $counter, 4, '0', STR_PAD_LEFT);
        }

        public static function getCompany($id){
            return DB::table('m_company')->where('c_id', $id)->first();
        }
    }
?>