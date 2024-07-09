<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use App\Models\User;
use App\Models\Produk;

use Carbon\Carbon;
class BerandaController extends Controller
{

    public function index(){
        $user = auth()->user();
        $ovr = Collect([
            'tools' => Produk::get()->count(),
            'user' => User::get()->count()
        ]);

        $now = Carbon::today();

        return view('admin.beranda',[
            'ovr' => $ovr,
        ]);
    }
}
