<?php

namespace App\Modules\Dasboard\Dashboard\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\d_user_kasus;
use App\Models\d_user_kasus_penyakit;
use App\Models\d_user_kasus_penyakit_detail;
use App\Models\m_gejala;
use App\Models\m_penyakit;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class DashboardController extends Controller
{
    public function getDataPertanyaan(Request $request) {
        $data = m_penyakit::with(['rules' => function($q) {
            $q->join('m_gejala', 'g_id', 'r_gejala_id');
        }])
        ->where('p_kode', '!=', 'P0000')
        ->get();

        return $data;
    }

    public function store(Request $request) {
        DB::beginTransaction();
        try {

            // return json_encode($request->all());

            $kasus = new d_user_kasus();
            $kasus->uk_user_id = Auth::user()->id;
            $kasus->uk_date    = Carbon::now();
            $kasus->save();

            foreach ($request->ukp_penyakit_id as $key => $value) {
                $penyakit = new d_user_kasus_penyakit();
                $penyakit->ukp_user_kasus_id = $kasus->uk_id;
                $penyakit->ukp_penyakit_id = $value;
                $penyakit->ukp_skor = 0;
                $penyakit->ukp_hasil = '';
                $penyakit->save();

                $skor = 0;
                $gejala_scores = [];
                foreach ($request->ukpd_gejala_id[$key] as $idx => $val) {
                    $detail = new d_user_kasus_penyakit_detail();
                    $detail->ukpd_kasus_penyakit_id = $penyakit->ukp_id;
                    $detail->ukpd_gejala_id         = $val;

                    $checked = false;
                    if (isset($request->ukpd_value[$key])) {
                        foreach ($request->ukpd_value[$key] as $i => $v) {
                            if ($v == $val) {
                                $checked = true;
                            }
                        }
                    }
                    
                    $detail->ukpd_value = $checked;

                    if ($checked) {
                        $gejala = m_gejala::where('g_id', $val)->first();
                        if (!$gejala) {
                            return response()->json([
                                'status' => 'error',
                                'message'=> 'Sedang terjadi kesalahan, segera hubungi developer!'
                            ]);
                        }

                        $skor += (float)$gejala->g_percent;
                        $gejala_scores[] = [
                            'bel'=>$gejala->g_bel,
                            'pls'=>$gejala->g_pls
                        ];
                    }

                    $detail->save();
                }

                usort($gejala_scores, function ($a, $b) {
                    return $a['bel'] <=> $b['bel'];
                });

                $result_score = 0;
                for ($i=0; $i <count($gejala_scores)-1 ; $i++) { 
                    if ($i < count($gejala_scores)-1) {
                        $dump = ($gejala_scores[$i]['bel'] * $gejala_scores[$i+1]['bel']) + ($gejala_scores[$i]['bel'] * $gejala_scores[$i+1]['pls']) + ($gejala_scores[$i]['pls'] * $gejala_scores[$i+1]['bel']);
                        $nextIndex = $i;
                        $nextIndex++;
                        $gejala_scores[$nextIndex]['bel'] = $dump;
                        $gejala_scores[$nextIndex]['pls'] = 1-$dump;
                    }
                }

                $last_index = count($gejala_scores) == 0 ? 0 : count($gejala_scores)-1;
                $ukp_score = count($gejala_scores) == 0 ? 0 : $gejala_scores[$last_index]['bel']*100;
                if (count($gejala_scores) == 1) {
                    $ukp_score = 0;
                }
                $penyakit->ukp_skor = $ukp_score;
                $ukp_hasil = '-';
                switch (count($gejala_scores)) {
                    case 1:
                        $ukp_hasil = 'Tidak Terindikasi';
                        break;
                    case 2:
                        $ukp_hasil = 'Terindikasi';
                        break;
                    case 3:
                        $ukp_hasil = 'Kecenderungan';
                        break;
                    case 4:
                        $ukp_hasil = 'Gangguan';
                        break;
                    case 5:
                        $ukp_hasil = 'Gangguan';
                        break;
                    default:
                        break;
                }
                $penyakit->ukp_hasil = $ukp_hasil;
                // if ($skor >= 20 && $skor < 30) {
                //     $penyakit->ukp_hasil = 'TERINDIKASI';
                // } else if ($skor >= 30 && $skor < 50) {
                //     $penyakit->ukp_hasil = 'KECENDERUNGAN';
                // } else if ($skor >= 50 && $skor <= 100) {
                //     $penyakit->ukp_hasil = 'GANGGUAN';
                // } else {
                //     $penyakit->ukp_hasil = 'TIDAK TERINDIKASI';
                // }
                $penyakit->save();
            }

            DB::commit();
            return response()->json([
                'status' => 'success',
                'message'=> 'Data berhasil disimpan!'
            ], 200);
        } catch (\Throwable $th) {
            dd($th->getMessage());
            $logData = [
                'message' => $th->getMessage()
            ];
            if ($th->getCode() == 400) {
                $code = 400;
                Log::notice('auth/auth - an user logged in', $logData);
            } else {
                $code = 500;
                Log::error('auth/auth - an user logged in', $logData);
            }
            return response()->json([
                'status' => 'error',
                'message' => $th->getMessage(),
                'data' => '',
            ], $code);
        }
    }

    private function sortByOrder($a, $b) {
        return $a['bel'] - $b['bel'];
    }

    public function getDataHistories(Request $request) {
        // return $request->user()->id;
        $userId = $request->user()->id;
        if (isset($request->user_id)) {
            $userId = $request->user_id;
        }

        $data = d_user_kasus::where('uk_user_id', $userId)
        ->with(['penyakit' => function($q) {
            $q->with(['detail' => function($r) {
                $r->join('m_gejala', 'g_id', 'ukpd_gejala_id');
            }]);
            $q->join('m_penyakit', 'p_id', 'ukp_penyakit_id');
        }])
        ->select('*', DB::raw('date_format(uk_date, "%a, %d/%m/%Y %h:%m") as is_date'))
        ->latest()->get();
        
        return $data;
    }
}
