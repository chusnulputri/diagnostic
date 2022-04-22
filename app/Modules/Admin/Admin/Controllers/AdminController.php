<?php

namespace App\Modules\Admin\Admin\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use App\Http\Controllers\Controller;
use App\Models\d_kasus;
use App\Models\d_user_kasus;
use App\Models\d_user_kasus_penyakit;
use App\Models\m_gejala;
use App\Models\m_penyakit;
use App\Models\d_rule;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    public function getDataUser (Request $request) {
        $data = User::where('type', '!=', 'admin')
        ->get();

        // $data->map(function ($item) {
            
        //     $item->aksi .= '<form action="'.route('Admin.hapus-user', $item->id).'" method="POST"><input type="hidden" name="_token" value="'.csrf_token().'"><input type="hidden" name="_method" value="DELETE"><button type="submit" class="btn btn-outline-secondary"><i class="fa fa-trash-alt"></i></button></form>';

        //     $item->aksi .= '</span>';
        //     return $item;
        // });

        return response()->json([
            'data' => $data
        ]);
    }

    public function getDataDiagnosa(Request $request) {
        $data = d_user_kasus_penyakit::with(['detail' => function($q) {
                $q->join('m_gejala', 'g_id', 'ukpd_gejala_id');
            }
        ])
        ->join('d_user_kasus', 'uk_id', 'ukp_user_kasus_id')
        ->join('users', 'id', 'uk_user_id')
        ->join('m_penyakit', 'p_id', 'ukp_penyakit_id')
        ->get();

        $data->map(function ($item) {
            
            $item->aksi .= '<form action="'.route('Admin.hapus-diagnosa', $item->ukp_id).'" method="POST"><input type="hidden" name="_token" value="'.csrf_token().'"><input type="hidden" name="_method" value="DELETE"><button type="submit" class="btn btn-outline-secondary"><i class="fa fa-trash-alt"></i></button></form>';

            $item->aksi .= '</span>';
            return $item;
        });

        return response()->json([
            'data' => $data
        ]);
    }

    public function getDataGejala(Request $request) {
        $data = m_gejala::all();
        $data->map(function ($item) {
           
            $item->aksi = '<script>console_log("string")</script><span><a href="#" class="edit-gejala btn btn-outline-secondary" data-url='.route('Admin.edit-gejala', $item->g_id).'><i class="fa fa-pencil-alt"></i> </a>';
            if (\Carbon\Carbon::parse($item->created_at) >= \Carbon\Carbon::parse('14-Feb-2022')) {
                $item->aksi .= '<form action="'.route('Admin.hapus-gejala', $item->g_id).'" method="POST"><input type="hidden" name="_token" value="'.csrf_token().'"><input type="hidden" name="_method" value="DELETE"><button type="submit" class="btn btn-outline-secondary"><i class="fa fa-trash-alt"></i></button></form>';
            }
            $item->aksi .= '</span>';
            return $item;
        });
        return response()->json([
            'data' => $data
        ]);

    }

    public function getDataPenyakit(Request $request) {
        $data = m_penyakit::all();
        $data->map(function ($item) {

            $item->aksi = '<span><a href="#" class="edit-penyakit btn btn-outline-secondary" data-url='.route('Admin.edit-penyakit', $item->p_id).'><i class="fa fa-pencil-alt"></i> </a>';
            if (\Carbon\Carbon::parse($item->created_at) >= \Carbon\Carbon::parse('14-Feb-2022')) {
                $item->aksi .= '<form action="'.route('Admin.hapus-penyakit', $item->p_id).'" method="POST"><input type="hidden" name="_token" value="'.csrf_token().'"><input type="hidden" name="_method" value="DELETE"><button type="submit" class="btn btn-outline-secondary"><i class="fa fa-trash-alt"></i></button></form>';
            }
            $item->aksi .= '</span>';
            return $item;
        });
        return response()->json([
            'data' => $data
        ]);

    }

    public function getDataRule(Request $request) {
        $data = d_rule::all();
        $data->map(function ($item) {

            $item->aksi = '<span><a href="#" class="edit-rule btn btn-outline-secondary" data-url='.route('Admin.edit-rule', $item->r_id).'><i class="fa fa-pencil-alt"></i> </a>';
            if (\Carbon\Carbon::parse($item->created_at) >= \Carbon\Carbon::parse('14-Feb-2022')) {
                $item->aksi .= '<form action="'.route('Admin.hapus-rule', $item->p_id).'" method="POST"><input type="hidden" name="_token" value="'.csrf_token().'"><input type="hidden" name="_method" value="DELETE"><button type="submit" class="btn btn-outline-secondary"><i class="fa fa-trash-alt"></i></button></form>';
            }
            $item->aksi .= '</span>';
            return $item;
        });
        return response()->json([
            'data' => $data
        ]);

    }

    public function getDataKasus(Request $request) {
        $data = d_kasus::all();
        $data->map(function ($item) {
           
            $item->aksi = '<span><a href="#" class="edit-kasus" data-url='.route('Admin.edit-kasus', $item->g_id).'><button class="btn btn-outline-warning">Edit</a>';
            if (\Carbon\Carbon::parse($item->created_at) >= \Carbon\Carbon::parse('14-Feb-2022')) {
                $item->aksi .= '<a href="'.route('Admin.hapus-kasus', $item->g_id).'"><button class="btn btn-outline-danger">Delete</a>';
            }
            $item->aksi .= '</span>';
            return $item;
        });
        return response()->json([
            'data' => $data
        ]);
    }

    public function detailRule($id)
    {
        $data = d_rule::find($id);

        return response()->json([
            'data' => $data,
            'update_url' =>  route('Admin.update-rule', $id)
        ]);
    }

    public function updateRule(Request $request, $id)
    {
        d_rule::find($id)->update($request->all());
        return view('Admin::rule');
    }

    public function tambahRule(Request $request) 
    {
        $data = $request->except(['_token', 'submit']);
        try {
            d_rule::create($data);
        } catch(\Exception $e) {
            dd($e->getMessage());
        }

        return view('Admin::rule');
        
    }


    public function hapusRule($id)
    {
        $data = d_rule::find($id);

        // if($data->delete()) {
        //     return redirect()->route('admin.gejala')->with('message', 'Berhasil menghapus data');
        // } else {
        //     return redirect()->route('admin.gejala')->with('message', 'Gagal menghapus data');
        // }
        try {
            d_rule::destroy($id);
        } catch(\Exception $e) {
            dd($e->getMessage());
        }
        return redirect()->route('Admin.gejala')->with('message', 'Berhasil menghapus data');
        // return view('Admin::gejala');
    }

    public function detailGejala($id)
    {
        $data = m_gejala::find($id);

        return response()->json([
            'data' => $data,
            'update_url' =>  route('Admin.update-gejala', $id)
        ]);
    }

    public function updateGejala(Request $request, $id)
    {
        m_gejala::find($id)->update($request->all());
        return view('Admin::gejala');
    }

    public function tambahGejala(Request $request) 
    {
        $data = $request->except(['_token', 'submit']);
        try {
            m_gejala::create($data);
        } catch(\Exception $e) {
            dd($e->getMessage());
        }

        return view('Admin::gejala');
        
    }

    public function hapusGejala($id)
    {
        $data = m_gejala::find($id);

        // if($data->delete()) {
        //     return redirect()->route('admin.gejala')->with('message', 'Berhasil menghapus data');
        // } else {
        //     return redirect()->route('admin.gejala')->with('message', 'Gagal menghapus data');
        // }
        try {
            m_gejala::destroy($id);
        } catch(\Exception $e) {
            return redirect()->route('admin.gejala')->with('message', 'Gagal menghapus data');
        }
        return redirect()->route('Admin.gejala')->with('message', 'Berhasil menghapus data');
        // return view('Admin::gejala');
    }


    public function detailPenyakit($id)
    {
        $data = m_penyakit::find($id);

        return response()->json([
            'data' => $data,
            'update_url' =>  route('Admin.update-penyakit', $id)
        ]);
    }

    public function updatePenyakit(Request $request, $id)
    {
        m_penyakit::find($id)->update($request->all());
        return view('Admin::penyakit');
    }

    
    public function tambahPenyakit(Request $request) 
    {
        $data = $request->except(['_token', 'submit']);
        try {
            m_penyakit::create($data);
        } catch(\Exception $e) {
            dd($e->getMessage());
        }

        return view('Admin::penyakit');
        
    }

    public function hapusPenyakit($id)
    {
        try {
            m_penyakit::destroy($id);
        } catch(\Exception $e) {
            dd($e->getMessage());
        }

        return view('Admin::penyakit');
    }

    public function hapusDiagnosa($id)
    {
        try {
            d_user_kasus_penyakit::destroy($id);
        } catch(\Exception $e) {
            dd($e->getMessage());
        }

        return view('Admin::diagnosa');
    }

    public function hapusUser($id)
    {
        try {
            User::destroy($id);
        } catch(\Exception $e) {
            dd($e->getMessage());
        }

        return view('Admin::index');
    }

    public function tambahKasus(Request $request) 
    {
         $data = $request->except(['_token', 'submit']);
         try {
             d_kasus::create($data);
        } catch(\Exception $e) {
            dd($e->getMessage());
        }

        return view('Admin::kasus');
        
    }

     public function detailKasus($id)
    {
        $data = d_kasus::find($id);

        return response()->json([
            'data' => $data,
            'update_url' =>  route('Admin.update-kasus', $id)
        ]);
    }

    public function updateKasus(Request $request, $id)
    {
        d_kasus::find($id)->update($request->all());
        return view('Admin::kasus');
    }


    public function hapusKasus($id)
    {
        try {
            d_kasus::destroy($id);
        } catch(\Exception $e) {
            dd($e->getMessage());
        }

        return view('Admin::kasus');
    }


}
