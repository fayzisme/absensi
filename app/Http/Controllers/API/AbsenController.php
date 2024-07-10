<?php

namespace App\Http\Controllers\API;

use App\Helpers\ApiFormatter;
use App\Http\Controllers\Controller;
use App\Models\MappingShift;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AbsenController extends Controller
{
    public function index(Request $request)
    {   
        date_default_timezone_set('Asia/Jakarta');
        $user = User::find($request->user_id);
        $data = null;
        if ($user) {
            $tglskrg = date('Y-m-d');
            $tglkmrn = date('Y-m-d', strtotime('-1 days'));
            $data = MappingShift::where('user_id', $user->id)->whereBetween('tanggal', [$tglkmrn, $tglskrg])->with('Shift')->get();
        }

        if($data){
            return ApiFormatter::createApi(200, 'Success', $data);
        }else{
            return ApiFormatter::createApi(400, 'Failed');
        }
    }
}
