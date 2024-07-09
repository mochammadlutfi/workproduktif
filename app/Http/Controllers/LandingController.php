<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Models\Kategori;
class LandingController extends Controller
{

    public function index()
    {
        $kategori = Kategori::latest()->get();

        return view('landing.home',[
            'kategori' => $kategori
        ]);
    }
    
    public function about(Request $request)
    {
        return view('landing.about');
    }
}
