<?php

namespace App\Http\Controllers;

use App\Models\Lembur;
use App\Models\Lokasi;
use App\Models\User;
use App\Models\MappingShift;
use App\Models\Ijin;
use App\Models\Role;
use App\Models\Shift;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;


class karyawanController extends Controller
{
    public function index()
    {
        $search = request()->input('search');

        $data = User::when($search, function ($query) use ($search) {
                    $query->where('name', 'LIKE', '%'.$search.'%')
                          ->orWhere('email', 'LIKE', '%'.$search.'%')
                          ->orWhere('telepon', 'LIKE', '%'.$search.'%')
                          ->orWhere('username', 'LIKE', '%'.$search.'%');
                })
                ->with('Lokasi')
                ->orderBy('name', 'ASC')
                ->paginate(10)
                ->withQueryString();


        if (auth()->user()->Role->nama_role == 'admin') {
            return view('karyawan.index', [
                'title' => 'Pegawai',
                'data_user' => $data
            ]);
        } else {
            return view('karyawan.indexUser', [
                'title' => 'Pegawai',
                'data_user' => $data
            ]);
        }
    }

    public function euforia()
    {
        date_default_timezone_set('Asia/Jakarta');

        $data = User::where('tgl_lahir', date('Y-m-d'))
                ->orderBy('name', 'ASC')
                ->paginate(10)
                ->withQueryString();
        
        return view('karyawan.euforia', [
            'title' => 'Euforia',
            'data_user' => $data
        ]);
        
    }
    
    public function show($id)
    {
        $user = User::find($id);

        return view('karyawan.show', [
            'title' => 'Detail Karyawan',
            'user' => $user
        ]);
    }

    public function tambahKaryawan()
    {
        return view('karyawan.tambah',[
            "title" => 'Tambah Pegawai',
            "data_lokasi" => Lokasi::where('status', 'approved')->get()
        ]);
    }

    public function tambahKaryawanProses(Request $request)
    {
        $validatedData = $request->validate([
            'npk' => 'required|max:255|unique:users',
            'name' => 'required|max:255',
            'foto_karyawan' => 'image|file|max:10240',
            'email' => 'required|email:dns|unique:users',
            'telepon' => 'required',
            'username' => 'required|max:255|unique:users',
            'password' => 'required|min:6|max:255',
            'tgl_lahir' => 'required',
            'gender' => 'required',
            'tgl_join' => 'required',
            'status_nikah' => 'required',
            'alamat' => 'required',
            'is_admin' => 'required'
        ]);

        if ($request->file('foto_karyawan')) {
            $validatedData['foto_karyawan'] = $request->file('foto_karyawan')->store('foto_karyawan');
        }
        
        $role_id = Role::where('nama_role', $validatedData['is_admin'])->first();
        if ($role_id) {
            $validatedData['id_role'] = $role_id->id;
        }

        $validatedData['password'] = Hash::make($validatedData['password']);
        User::create($validatedData);
        return redirect('/pegawai')->with('success', 'Data Berhasil di Tambahkan');
    }

    public function detail($id)
    {
        return view('karyawan.editkaryawan', [
            'title' => 'Detail Pegawai',
            'karyawan' => User::find($id),
            'data_lokasi' => Lokasi::where('status', 'approved')->get()
        ]);
    }

    public function editKaryawanProses(Request $request, $id)
    {
        $rules = [
            'name' => 'required|max:255',
            'foto_karyawan' => 'image|file|max:10240',
            'telepon' => 'required',
            'password' => 'required',
            'tgl_lahir' => 'required',
            'gender' => 'required',
            'tgl_join' => 'required',
            'status_nikah' => 'required',
            'alamat' => 'required',
            // 'is_admin' => 'required',
            'lokasi_id' => 'required',
        ];


        $userId = User::find($id);

        if ($request->email != $userId->email) {
            $rules['email'] = 'required|email:dns|unique:users';
        }

        if ($request->username != $userId->username) {
            $rules['username'] = 'required|max:255|unique:users';
        }

        $validatedData = $request->validate($rules);

        if ($request->file('foto_karyawan')) {
            if ($request->foto_karyawan_lama) {
                Storage::delete($request->foto_karyawan_lama);
            }
            $validatedData['foto_karyawan'] = $request->file('foto_karyawan')->store('foto_karyawan');
        }


        User::where('id', $id)->update($validatedData);
        $request->session()->flash('success', 'Data Berhasil di Update');
        return redirect('/pegawai');
    }

    public function deleteKaryawan($id)
    {
        $delete = User::find($id);
        MappingShift::where('user_id', $id)->delete();
        Lembur::where('user_id', $id)->delete();
        Storage::delete($delete->foto_karyawan);
        $delete->delete();
        return redirect('/pegawai')->with('success', 'Data Berhasil di Delete');
    }

    public function editpassword($id)
    {
        return view('karyawan.editpassword', [
            'title' => 'Edit Password',
            'karyawan' => User::find($id)
        ]);
    }

    public function ajaxDescrip(Request $request)
    {
        $json = file_get_contents('neural.json');
        if(strlen($json) > 4){
            $string = ',' . $request["myData"]; 
        }
        else{
            $string = $request["myData"];
        }
        $position = strlen($json) - 2; 
        $out = substr_replace( $json, $string, $position, 0 ); 
        file_put_contents('neural.json', $out);
    }

    public function ajaxPhoto(Request $request)
    {
        $image = $request["image"];

        $image_parts = explode(";base64,", $image);
    
        $image_base64 = base64_decode($image_parts[1]);
        $fileName = 'foto_face_recognition/' . $request["path"] . '.png';
    
        Storage::put($fileName, $image_base64);

        $user = User::where('username', $request['path'])->update(["foto_face_recognition" => $fileName]);
        return $user;
    }

    public function editPasswordProses(Request $request, $id)
    {
        $validatedData = $request->validate([
            'password' => 'required|min:6|max:255',
        ]);

        $validatedData['password'] = Hash::make($request->password);

        User::where('id', $id)->update($validatedData);
        $request->session()->flash('success', 'Password Berhasil Diganti');
        return redirect('/pegawai');
    }

    public function shift($id)
    {
        $tanggal = request()->input('tanggal');
        $mapping_shift = MappingShift::where('user_id', $id)
                                    ->when($tanggal, function ($query) use ($tanggal) {
                                        return $query->where('tanggal', $tanggal);
                                    })
                                    ->orderBy('tanggal', 'DESC')
                                    ->paginate(10)
                                    ->withQueryString();
        return view('karyawan.mappingshift', [
            'title' => 'Mapping Shift',
            'karyawan' => User::find($id),
            'shift_karyawan' => $mapping_shift,
            'shift' => Shift::all()
        ]);
    }

    public function prosesTambahShift(Request $request)
    {
        date_default_timezone_set('Asia/Jakarta');

        $request->validate([
            'shift_id' => 'required',
            'tanggal_mulai' => 'required',
            'tanggal_akhir' => 'required',
        ]);

        if($request["tanggal_mulai"] == null) {
            $request["tanggal_mulai"] = $request["tanggal_akhir"];
        } else {
            $request["tanggal_mulai"] = $request["tanggal_mulai"];
        }

        if($request["tanggal_akhir"] == null) {
            $request["tanggal_akhir"] = $request["tanggal_mulai"];
        } else {
            $request["tanggal_akhir"] = $request["tanggal_akhir"];
        }

        $begin = new \DateTime($request["tanggal_mulai"]);
        $end = new \DateTime($request["tanggal_akhir"]);
        $end = $end->modify('+1 day');

        $interval = new \DateInterval('P1D'); //referensi : https://en.wikipedia.org/wiki/ISO_8601#Durations
        $daterange = new \DatePeriod($begin, $interval ,$end);


        foreach ($daterange as $date) {
            $tanggal = $date->format("Y-m-d");

            $cek = MappingShift::where('user_id', $request['user_id'])->where('tanggal', $tanggal)->first();

            if (!$cek) {
                if ($request["shift_id"] == 1) {
                    $request["status_absen"] = "Libur";
                } else {
                    $request["status_absen"] = "Tidak Masuk";
                }
    
                $request["tanggal"] = $tanggal;
    
                $validatedData = $request->validate([
                    'user_id' => 'required',
                    'shift_id' => 'required',
                    'tanggal' => 'required',
                    'status_absen' => 'required',
                ]);

                $validatedData['lock_location'] = $request['lock_location'] ? $request['lock_location'] : null;
                $validatedData['telat'] = 0;
                $validatedData['pulang_cepat'] = 0;
    
                MappingShift::create($validatedData);
            }
        }
        return redirect('/pegawai/shift/' . $request["user_id"])->with('success', 'Data Berhasil di Tambahkan');
    }

    public function deleteShift(Request $request, $id)
    {
        $delete = MappingShift::find($id);
        $delete->delete();
        return redirect('/pegawai/shift/' . $request["user_id"])->with('success', 'Data Berhasil di Delete');
    }

    public function editShift($id)
    {
        return view('karyawan.editshift', [
            'title' => 'Edit Shift',
            'shift_karyawan' => MappingShift::find($id),
            'shift' => Shift::all()
        ]);
    }

    public function prosesEditShift(Request $request, $id)
    {
        date_default_timezone_set('Asia/Jakarta');


        if ($request["shift_id"] == 1) {
            $request["status_absen"] = "Libur";
        } else {
            $request["status_absen"] = "Tidak Masuk";
        }

        $validatedData = $request->validate([
            'shift_id' => 'required',
            'tanggal' => 'required',
            'status_absen' => 'required'
        ]);

        $validatedData['lock_location'] = $request['lock_location'] ? $request['lock_location'] : null;

        MappingShift::where('id', $id)->update($validatedData);
        return redirect('/pegawai/shift/' . $request["user_id"])->with('success', 'Data Berhasil di Update');
    }

    public function myProfile()
    {
        if (auth()->user()->Role->nama_role == 'admin') {
            return view('karyawan.myprofile', [
                'title' => 'My Profile',
            ]);
            
        } else {
            return view('karyawan.myprofileuser', [
                'title' => 'My Profile',
            ]);
        }
    }

    public function myProfileUpdate(Request $request, $id)
    {
        $rules = [
            'name' => 'required|max:255',
            'foto_karyawan' => 'image|file|max:10240',
            'telepon' => 'required',
            'password' => 'required',
            'tgl_lahir' => 'required',
            'gender' => 'required',
            'tgl_join' => 'required',
            'status_nikah' => 'required',
            'alamat' => 'required'
        ];


        $userId = User::find($id);

        if ($request->email != $userId->email) {
            $rules['email'] = 'required|email:dns|unique:users';
        }

        if ($request->username != $userId->username) {
            $rules['username'] = 'required|max:255|unique:users';
        }

        $validatedData = $request->validate($rules);

        if ($request->file('foto_karyawan')) {
            if ($request->foto_karyawan_lama) {
                Storage::delete($request->foto_karyawan_lama);
            }
            $validatedData['foto_karyawan'] = $request->file('foto_karyawan')->store('foto_karyawan');
        }


        User::where('id', $id)->update($validatedData);
        $request->session()->flash('success', 'Data Berhasil di Update');
        return redirect('/my-profile');
    }

    public function editPassMyProfile()
    {
        if (auth()->user()->Role->nama_role == 'admin') {
            return view('karyawan.editpassmyprofile', [
                'title' => 'Ganti Password'
            ]);
        } else {
            return view('karyawan.editpassworduser', [
                'title' => 'Ganti Password'
            ]);
        }
        
    }

    public function editPassMyProfileProses(Request $request, $id)
    {
        $validatedData = $request->validate([
            'password' => 'required|min:6|max:255|confirmed',
        ]);

        $validatedData['password'] = Hash::make($request->password);

        User::where('id', $id)->update($validatedData);
        $request->session()->flash('success', 'Password Berhasil di Update');
        return redirect('/dashboard');
    }

    public function resetCuti()
    {
        return view('karyawan.masterreset', [
            'title' => 'Master Data Reset Cuti',
            'data_cuti' => Ijin::first()
        ]);
    }

    public function resetCutiProses(Request $request, $id)
    {
        $validatedData = $request->validate([
            'id_user' => 'required',
        ]);

        $ids = [];
        $reset = [];

        Ijin::whereIn('id', $ids)->update($reset);
        return redirect('/reset-cuti')->with('success', 'Master Cuti Berhasil Diupdate');
    }

}
