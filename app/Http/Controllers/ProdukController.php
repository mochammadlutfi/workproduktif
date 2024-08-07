<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use DataTables;
use Carbon\Carbon;
use App\Models\Produk;
use App\Models\Kategori;


use App\Services\Midtrans\CreateSnapTokenService;
use App\Services\Midtrans\CallbackService;

use PDF;
class ProdukController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $data = Kategori::latest()->get();

        return view('landing.produk.index',[
            'data' => $data
        ]);
    }

    public function kategori($kategori, Request $request)
    {
        $ct = Kategori::where('slug', $kategori)->first();

        $data = Produk::orderBy('id', 'DESC')->where('kategori_id', $ct->id)
        ->paginate(9);

        return view('landing.produk.kategori',[
            'kategori' => $ct,
            'data' => $data
        ]);
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($kategori, $slug)
    {
        $data = Produk::where('slug', $slug)->first();
        // dd($data);
        return view('landing.produk.show', [
            'data' => $data
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function register(Request $request)
    {
        DB::beginTransaction();
        try{
            $user = auth()->guard('web')->user();
            $training = Training::where('id', $request->training_id)->first();

            $data = new UserTraining();
            $data->nomor = $this->getNumber($request->training_id);
            $data->user_id = $user->id;
            $data->training_id = $request->training_id;
            $data->status = 'pending';
            $data->save();
            
            $snapToken = "";
            if($training->harga){
                $midtrans = new CreateSnapTokenService([
                    'id' => rand(),
                    'nomor' => $data->id,
                    'jumlah' => $training->harga,
                    'pelanggan_nama' => $user->nama,
                    'pelanggan_email' => $user->email,
                    'pelanggan_phone' => $user->hp,
                ]);
    
                $snapToken = $midtrans->getSnapToken();
                $data->snap = $snapToken;
                $data->save();
            }else{
                $data->status = 'lunas';
                $data->save();
            }
        }catch(\QueryException $e){
            DB::rollback();
            return response()->json([
                'fail' => true,
                'pesan' => $e,
            ]);
        }

        DB::commit();
        return response()->json([
            'fail' => false,
            'snapToken' => $snapToken
        ]);
    }

    public function update(Request $request)
    {
        // dd($request->all());
        DB::beginTransaction();
        try{
            $user = auth()->guard('web')->user();

            // if($request->status == 'settlement'){
            //     $status = 'terima';
            // }else{
            //     $status = 'pending';
            // }

            $data = UserTraining::where('user_id', $user->id)->where('training_id', $request->id)->first();
            $data->status = $request->status;
            $data->save();

        }catch(\QueryException $e){
            DB::rollback();
            return response()->json([
                'fail' => true,
                'pesan' => $e,
            ]);
        }

        DB::commit();
        return response()->json([
            'fail' => false,
        ]);
    }

}
