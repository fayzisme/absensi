<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Lokasi;
use App\Models\MappingShift;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use RealRashid\SweetAlert\Facades\Alert;

class authController extends Controller
{
    public function index()
    {
        return view('auth.loginAdmin',[
            "title" => "Log In"
        ]);
    }

    public function loginAdmin()
    {
        return view('auth.login',[
            "title" => "Log In"
        ]);
    }

    public function register()
    {
        return view('auth.register', [
            "title" => "Register Account",
            "data_lokasi" => Lokasi::where('status', 'approved')->get()
        ]);
    }

    public function presensi()
    {
        return view('auth.presensi', [
            "title" => "Presensi Masuk",
        ]);
    }

    public function presensiPulang()
    {
        return view('auth.presensiPulang', [
            "title" => "Presensi Pulang",
        ]);
    }

    public function presensiStore(Request $request)
    {
        date_default_timezone_set('Asia/Jakarta');
        $currentDate = date('Y-m-d');
        $user = User::where('username', $request['username'])->first();
        if ($user) {
            $ms = MappingShift::where('user_id', $user->id)->where('tanggal', $currentDate)->first();
            if ($ms) {
                if($ms->jam_absen == null) {
                    $image = $request["image"];

                    $image_parts = explode(";base64,", $image);
                
                    $image_base64 = base64_decode($image_parts[1]);
                    $fileName = 'foto_jam_absen/' . uniqid() . '.png';

                    $status_absen = "Masuk";
                    $jam_absen = date('H:i');
                    $tgl_skrg = date("Y-m-d");
            
                    $awal  = strtotime($ms->tanggal . $ms->Shift->jam_masuk);
                    $akhir = strtotime($tgl_skrg . $jam_absen);
                    $diff  = $akhir - $awal;
            
                    if ($diff <= 0) {
                        $telat= 0;
                    } else {
                        $telat= $diff;
                    }
                
                    Storage::put($fileName, $image_base64);
                    $ms->update([
                        'jam_absen' => $jam_absen,
                        'telat' => $telat,
                        'foto_jam_absen' => $fileName,
                        'lat_absen' => $user->Lokasi->lat_kantor,
                        'long_absen' => $user->Lokasi->long_kantor,
                        'jarak_masuk' => '0',
                        'status_absen' => $status_absen
                    ]);
                    return response()->json('masuk');
                } else {
                    return response()->json('selesai');
                }
            } else {
                return response()->json('noMs');
            }
        } else {
            return response()->json('noUser');
        }
    }

    public function presensiPulangStore(Request $request)
    {
        date_default_timezone_set('Asia/Jakarta');
        $currentDate = date('Y-m-d');
        $user = User::where('username', $request['username'])->first();
        if ($user) {
            $ms = MappingShift::where('user_id', $user->id)->where('tanggal', $currentDate)->first();
            if ($ms) {
                if($ms->jam_pulang == null) {
                    $image = $request["image"];

                    $image_parts = explode(";base64,", $image);
                
                    $image_base64 = base64_decode($image_parts[1]);
                    $fileName = 'foto_jam_pulang/' . uniqid() . '.png';
                    $jam_pulang = date('H:i');

                    $new_tanggal = "";
                    $timeMasuk = strtotime($ms->Shift->jam_masuk);
                    $timePulang = strtotime($ms->Shift->jam_keluar);
            
                    if ($timePulang < $timeMasuk) {
                        $new_tanggal = date('Y-m-d', strtotime('+1 days', strtotime($ms->tanggal)));
                    } else {
                        $new_tanggal = $ms->tanggal;
                    }
            
                    $tgl_skrg = date("Y-m-d");
            
                    $akhir = strtotime($new_tanggal . $ms->Shift->jam_keluar);
                    $awal  = strtotime($tgl_skrg . $jam_pulang);
                    $diff  = $akhir - $awal;
            
                    if ($diff <= 0) {
                        $pulang_cepat = 0;
                    } else {
                        $pulang_cepat = $diff;
                    }
                
                    Storage::put($fileName, $image_base64);
                    $ms->update([
                        'jam_pulang' => $jam_pulang,
                        'pulang_cepat' => $pulang_cepat,
                        'foto_jam_pulang' => $fileName,
                        'lat_pulang' => $user->Lokasi->lat_kantor,
                        'long_pulang' => $user->Lokasi->long_kantor,
                        'jarak_pulang' => '0',
                    ]);
                    return response()->json('pulang');
                } else {
                    return response()->json('selesai');
                }
            } else {
                return response()->json('noMs');
            }
        } else {
            return response()->json('noUser');
        }
    }

    public function ajaxGetNeural()
    {
        $inp = file_get_contents('neural.json');
        $tempArray = json_decode($inp);
        $jsonData = json_encode($tempArray);
        echo $jsonData;
    }

    public function registerProses(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|max:255',
            'username' => 'required|unique:users|max:7',
            'email' => 'required|email:dns|unique:users',
            'password' => 'required|confirmed|min:6|max:255',
            'lokasi_id' => 'required',
        ]);

        if ($request->file('foto_karyawan')) {
            $validatedData['foto_karyawan'] = $request->file('foto_karyawan')->store('foto_karyawan');
        }

        $validatedData['is_admin'] = 'user';
        $validatedData['password'] = Hash::make($validatedData['password']);
        $validatedData['id_role'] = 2;
        User::create($validatedData);
        return redirect('/')->with('success', 'Berhasil Register! Silahkan Login');
    }

    public function loginProses(Request $request)
    {
        $credentials = $request->validate([
            'username' => 'required',
            'password' => 'required'
        ]);
        
        $remember_me = $request->has('remember') ? true : false;

        if (Auth::attempt($credentials, $remember_me)) {
            $request->session()->regenerate();

            return redirect()->intended('/dashboard');
        }

        Alert::error('Failed', 'Username / Password Salah');
        return back();
    }

    public function loginProsesUser(Request $request)
    {
        $credentials = $request->validate([
            'username' => 'required',
            'password' => 'required'
        ]);
        
        $remember_me = $request->has('remember') ? true : false;

        if (Auth::attempt($credentials, $remember_me)) {
            $request->session()->regenerate();

            return redirect()->intended('/dashboard');
        }

        Alert::error('Failed', 'Username / Password Salah');
        return back();
    }

    public function logout(Request $request)
    {
        $is_admin = auth()->user()->Role->nama_role;
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        if ($is_admin == 'admin') {
            return redirect('/login-admin');
        } else {
            return redirect('/');
        }
    }
}
