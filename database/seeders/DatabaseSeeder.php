<?php

namespace Database\Seeders;

use App\Models\Lokasi;
use App\Models\Role;
use App\Models\User;
use App\Models\Shift;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {

        $role_admin = Role::create([
            'nama_role' => 'admin'
        ]);

        $role_user = Role::create([
            'nama_role' => 'user'
        ]);

        User::create([
            'name' => 'Admin',
            'foto_karyawan' => null,
            'email' => 'admin@gmail.com',
            'telepon' => '082343435456',
            'username' => 'admin',
            'password' => Hash::make('password'),
            'tgl_lahir'=> '2000-02-29',
            'gender' => 'L',
            'tgl_join' => '2024-07-01',
            'status_nikah'=> 'jomblo',
            'alamat' => 'Jln - jln',
            'lokasi_id' => 1,
            'id_role' => $role_admin->id
        ]);

        User::create([
            'npk' => '123',
            'name' => 'User',
            'foto_karyawan' => null,
            'email' => 'user@gmail.com',
            'telepon' => '081343599560',
            'username' => 'user',
            'password' => Hash::make('password'),
            'tgl_lahir'=> '2000-02-29',
            'gender' => 'L',
            'tgl_join' => '2024-07-01',
            'status_nikah'=> 'jomblo',
            'alamat' => 'Jln - jln',
            'lokasi_id' => 1,
            'id_role' => $role_user->id
        ]);
       

        Shift::create([
            'nama_shift' => "Libur",
            'jam_masuk' => "00:00",
            'jam_keluar' => "00:00",
        ]);

        Shift::create([
            'nama_shift' => "Pagi",
            'jam_masuk' => "08:00",
            'jam_keluar' => "17:00",
        ]);

        Shift::create([
            'nama_shift' => "Siang",
            'jam_masuk' => "13:00",
            'jam_keluar' => "21:00",
        ]);

        Shift::create([
            'nama_shift' => "Malam",
            'jam_masuk' => "21:00",
            'jam_keluar' => "05:00",
        ]);

        Lokasi::create([
            'nama_lokasi' => 'Kantor Cabang A',
            'lat_kantor' => '-6.3707314',
            'long_kantor' => '106.8138057',
            'radius' => '200',
            'status' => 'approved',
            'created_by' => 1
        ]);

    }
}
