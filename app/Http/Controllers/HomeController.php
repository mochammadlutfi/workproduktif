<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class HomeController extends Controller
{

    public function index(){
        $user = auth()->user();
        if($user->level == 'admin'){
            $ovr = Collect([
                'ekskul' => Ekskul::where('status', 1)->get()->count(),
                'pembina' => User::where('level', 'pembina')->get()->count(),
                'ketua' => User::where('level', 'ketua')->get()->count(),
            ]);
        }else if($user->level == 'pembina'){
            $ovr = Collect([
                'ekskul' => Ekskul::where('status', 1)->where('pembina_id', $user->id)->get()->count(),
                'pembina' => User::where('level', 'pembina')->get()->count(),
                'ketua' => User::where('level', 'ketua')->get()->count(),
            ]);
        }else{
            $uid = $user->id;
            $ekskul = Ekskul::where('ketua_id', $uid)->get()->pluck('id');

            $ovr = Collect([
                'aktif' => AnggotaEkskul::whereIn('ekskul_id', $ekskul)->where('status', 'aktif')->get()->count(),
                'baru' =>  AnggotaEkskul::whereIn('ekskul_id', $ekskul)->where('status', 'draft')->get()->count(),
                'ditolak' =>  AnggotaEkskul::whereIn('ekskul_id', $ekskul)->whereIn('status', ['tolak', 'keluar'])->get()->count(),
            ]);
        }

        return view('dashboard',[
            'ovr' => $ovr,
        ]);
    }

    public function about(){


        return view('landing.about');
    }
}
