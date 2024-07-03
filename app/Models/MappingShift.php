<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MappingShift extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    public function User()
    {
        return $this->belongsTo(User::class);
    }

    public function Shift()
    {
        return $this->belongsTo(Shift::class);
    }

    public static function dataAbsen()
    {
        date_default_timezone_set('Asia/Jakarta');
        $tglskrg = date('Y-m-d');

        $user_id = request()->input('user_id');
        $mulai = request()->input('mulai');
        $akhir = request()->input('akhir');

        $data_absen = MappingShift::select('mapping_shifts.*', 'users.name')
                                    ->rightJoin('users', function($join) use ($tglskrg) {
                                        $join->on('users.id', '=', 'mapping_shifts.user_id')
                                            ->where('mapping_shifts.tanggal', '=', $tglskrg);
                                    })
                                    ->when(auth()->user()->Role->nama_role == 'user', function ($query) {
                                        return $query->where('users.id', auth()->user()->id);
                                    })
                                    ->when($user_id, function ($query) use ($user_id) {
                                        return $query->where('users.id', $user_id);
                                    })
                                    ->when($mulai && $akhir, function ($query) use ($mulai, $akhir, $user_id) {
                                        return MappingShift::rightJoin('users', function($join) use ($mulai, $akhir) {
                                                                $join->on('users.id', '=', 'mapping_shifts.user_id')
                                                                    ->whereBetween('tanggal', [$mulai, $akhir]);
                                                            })
                                                            ->when($user_id, function ($query) use ($user_id) {
                                                                return $query->where('users.id', $user_id);
                                                            });
                                    })
                                    ->orderBy('users.name', 'ASC')
                                    ->orderBy('mapping_shifts.tanggal', 'ASC');

        return $data_absen;
    }
}
