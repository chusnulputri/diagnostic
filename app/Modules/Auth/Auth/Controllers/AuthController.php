<?php

namespace App\Modules\Auth\Auth\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Mail\mailSender;
use App\Models\User;
use Exception;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        // return json_encode($request->all());
        DB::beginTransaction();
        try {
            $validator = Validator::make($request->all(), [
                'email' => 'required|email',
                'name' => 'required',
                'gender' => 'required',
                'bod' => 'required'
            ], [
                'email.required' => 'Email tidak boleh kosong',
                'name.required' => 'Nama tidak boleh kosong',
                'gender.required' => 'Jenis kelamin tidak boleh kosong',
                'bod.required' => 'Tanggal lahir tidak boleh kosong'
            ]);
            if ($validator->fails()) {
                throw new Exception($validator->errors()->first(), 400);
            }
            $user = User::where('email', $request->email)->first();
            if ($user) {
                throw new Exception("Email yang anda masukan sudah digunakan", 400);
            }
            $user = User::where('email', $request->email)->withTrashed()->first();
            if ($user) {
                throw new Exception("Email yang anda masukan sudah digunakan, silahkan aktifkan ulang", 400);
            }

            $password = $request->password ?? Str::random(8);
            $user = new User;
            $user->name     = $request->name;
            $user->gender   = $request->gender;
            $user->bod      = $request->bod;
            $user->address  = $request->address;
            $user->email    = $request->email;
            $user->password = Hash::make($password);
            $user->save();

            Log::info('auth/auth - new user registered');

            DB::commit();
            return response()->json([
                'status'  => 'success',
                'message' => 'Berhasil menambahkan data user',
                'data'    => $user,
            ]);
        } catch (\Throwable $th) {
            $logData = [
                'message' => $th->getMessage()
            ];
            if ($th->getCode() == 400) {
                $code = 400;
                Log::notice('auth/auth - new user registered', $logData);
            } else {
                $code = 500;
                Log::error('auth/auth - new user registered', $logData);
            }
            return response()->json([
                'status' => 'error',
                'message' => $th->getMessage(),
                'data' => '',
            ], $code);
        }
    }

    public function login(Request $request)
    {
        try {
            $user = User::where('email', $request->email)->first();

            if (!$user) {
                throw new Exception("User tidak ditemukan", 400);
            }
            if (!Hash::check($request->password, $user->password)) {
                throw new Exception("Password salah !", 400);
            }

            Auth::login($user);
            $request->session()->regenerate();

            Log::info('auth/auth - an user logged in');
        } catch (\Throwable $th) {
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

    public function logout(Request $request)
    {
        
        $request->session()->invalidate();

        return redirect()->route('login');
    }

    public function changePassword(Request $request)
    {
        DB::beginTransaction();
        try {
            $validator = Validator::make($request->all(), [
                'old_password' => 'required',
                'new_password' => 'required|min:8',
                'new_password_confirm' => 'required|same:new_password|min:8'
            ], [
                'old_password.required' => 'Password lama tidak boleh kosong',
                'new_password.required' => 'Password tidak boleh kosong',
                'new_password.min' => 'Password minimal karakter 8',
                'new_password_confirm.required' => 'Konfirmasi password tidak boleh kosong',
                'new_password_confirm.same' => 'Password tidak sama'
            ]);
            if ($validator->fails()) {
                throw new Exception($validator->errors()->first(), 400);
            }

            $user = getUserDetail($request);
            if (!$user) {
                throw new Exception("Data tidak ditemukan", 400);
            }

            if (!Hash::check($request->old_password, $user->password)) {
                throw new Exception("Password lama tidak sama", 400);
            }
            $user->password = Hash::make($request->new_password);
            $user->update();
            DB::commit();

            if ($request->header('from') === 'mobile') {
                $request->user()->tokens()->delete();
            } else {
                // Auth::guard('web')->logoutOtherDevices($request->new_password);
                // $this->logout($request);
            }

            Log::info('auth/auth - change password', [
                'user_id' => getUserDetail($request)->id,
                'company_id' => $request->user()->uc_company_id,
                'data' => []
            ]);

            return response()->json([
                'status' => 'success',
                'message' => 'Password berhasil diperbarui'
            ]);
        } catch (\Throwable $th) {
            $th->getCode() == 400 ? $code = 400 : $code = 500;
            $logData = [
                'user_id' => getUserDetail($request)->id,
                'company_id' => $request->user()->uc_company_id,
                'message' => $th->getMessage()
            ];
            if ($code == 400) {
                Log::notice('auth/auth - change password', $logData);
            } else {
                Log::error('auth/auth - change password', $logData);
            }
            return response()->json([
                'status' => 'error',
                'message' => $th->getMessage()
            ], $code);
        }
    }

    public function updateProfile(Request $request)
    {
        DB::beginTransaction();
        try {
            $validator = Validator::make($request->all(), [
                'u_date_of_birth' => 'sometimes|nullable|date_format:Y-m-d',
            ], [
                'u_date_of_birth.date_format' => 'Format tanggal tidak sesuai, gunakan format ( Y-m-d )',
            ]);
            if ($validator->fails()) {
                throw new Exception($validator->errors()->first(), 400);
            }

            $user = getUserDetail($request);
            $birthDay = null;
            if ($request->u_date_of_birth) {
                $birthDay = Carbon::createFromFormat('Y-m-d', $request->u_date_of_birth);
            }
            $user->name = $request->name ?? $user->name;
            $user->u_phone = $request->u_phone ?? $user->u_phone;
            $user->u_gender = $request->u_gender ?? $user->u_gender;
            $user->u_date_of_birth = $birthDay;
            $user->u_address = $request->u_address ?? $user->u_address;
            $user->u_province_id = $request->u_province_id ?? $user->u_province_id;
            $user->u_city_id = $request->u_city_id ?? $user->u_city_id;
            $user->u_district_id = $request->u_district_id ?? $user->u_district_id;

            $reqImage = $request->u_photo_file;

            if ($reqImage) {
                if (Storage::disk('public')->exists('berkas/profil/' . $user->u_photo)) {
                    Storage::disk('public')->delete('berkas/profil/' . $user->u_photo);
                }
                if (!Storage::disk('public')->exists('berkas/profil')) {
                    Storage::disk('public')->makeDirectory('berkas/profil');
                }

                if (count(explode(',', $reqImage)) > 1) {
                    $reqImage  = explode(',', $reqImage)[1];
                } else {
                    $reqImage  = explode(',', $reqImage)[0];
                }
                $ekstensi = 'png';
                if ($reqImage[0] == '/') {
                    $ekstensi = 'jpeg';
                } else if ($reqImage[0] == 'R') {
                    $ekstensi = 'gif';
                } else if ($reqImage[0] == 'U') {
                    $ekstensi = 'webp';
                }

                $file            = base64_decode($reqImage);
                $safeName        = Str::uuid() . '.' . $ekstensi;
                $destinationPath = storage_path() . '/app/public/berkas/profil/';
                file_put_contents($destinationPath . $safeName, $file);
                $user->u_photo = $safeName;
            }

            $user->save();

            Log::info('auth/auth - update profile', [
                'user_id' => getUserDetail($request)->id,
                'company_id' => $request->user()->uc_company_id,
                'data' => []
            ]);

            DB::commit();
            return response()->json([
                'status' => 'success',
                'message' => 'Data berhasil disimpan',
                'data' => $user
            ]);
        } catch (\Throwable $th) {
            DB::rollBack();
            $logData = [
                'user_id' => getUserDetail($request)->id,
                'company_id' => $request->user()->uc_company_id,
                'message' => $th->getMessage()
            ];
            if ($th->getCode() == 400) {
                $code = 400;
                Log::notice('auth/auth - update profile', $logData);
            } else {
                $code = 500;
                Log::error('auth/auth - update profile', $logData);
            }
            return response()->json([
                'status' => 'error',
                'message' => $th->getMessage(),
                'data' => '',
            ], $code);
        }
    }

    public function forgotPassword(Request $request)
    {
        DB::beginTransaction();
        try {
            $employee = User::where('email', $request->email)->first();
            if (!$employee) {
                throw new Exception("User tidak ditemukan", 400);
            }
            $password = Str::random(8);
            $dataEmail = [
                'password' => $password,
                'name' => $employee->name,
                'email' => $employee->email
            ];
            Mail::to($employee->email, $employee->u_nama)->queue(new mailSender('mail.register', 'Reset Password', $dataEmail));
            $employee->password = Hash::make($password);
            $employee->update();

            Log::info('auth/auth - forgot password', [
                'data' => [
                    'email' => $employee->email
                ]
            ]);

            DB::commit();
            return response()->json([
                'status' => 'success',
                'message' => 'Password berhasil direset silahkan cek email ' . $employee->email,
                'data' => $employee,
            ]);
        } catch (\Throwable $th) {
            DB::rollBack();
            $logData = [
                'message' => $th->getMessage()
            ];
            if ($th->getCode() == 400) {
                $code = 400;
                Log::notice('auth/auth - forgot password', $logData);
            } else {
                $code = 500;
                Log::error('auth/auth - forgot password', $logData);
            }
            return response()->json([
                'status' => 'error',
                'message' => $th->getMessage(),
                'data' => '',
            ], $code);
        }
    }
}
