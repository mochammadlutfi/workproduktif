<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use DataTables;
use App\Models\Order;
use App\Models\Produk;
use App\Models\User;
use PDF;
use App\Mail\OrderStatusMail;
use Illuminate\Support\Facades\Mail;


class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        $data = Order::with(['user'])->orderBy('id', 'DESC')->get();
        
        return view('admin.order.index',[
            'data' => $data
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $user = User::select('id as value', 'nama as label')->latest()->get();
        $produk = Produk::select('id as value', 'nama as label')->latest()->get();

        return view('admin.order.form',[
            'user' => $user,
            'produk' => $produk
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $rules = [
            'user_id' => 'required',
            'tgl' => 'required',
        ];

        $pesan = [
            'user_id.required' => 'Konsumen tidak boleh kosong',
            'tgl.required' => 'Tanggal tidak boleh kosong',
        ];


        $validator = Validator::make($request->all(), $rules, $pesan);
        if ($validator->fails()){
            return back()->withErrors($validator->errors());
        }else{
            DB::beginTransaction();
            try{

                $data = new Order();
                $data->user_id = $request->user_id;
                $data->nomor = $this->getNomor();
                $data->produk_id = $request->produk_id;
                $data->tgl = $request->tgl;
                $data->lama = $request->lama;
                $data->total = $request->total;
                $data->status = 'draft';
                $data->save();

            }catch(\QueryException $e){
                DB::rollback();
                return response()->json([
                    'fail' => true,
                    'errors' => $e,
                    'pesan' => 'Error Menyimpan Data Anggota',
                ]);
            }

            DB::commit();
            return redirect()->route('admin.order.index');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id, Request $request)
    {
        $data = Order::with('user')
        ->withSum(['pembayaran' => fn ($query) => $query->where('status', 'terima')], 'jumlah')
        ->where('id', $id)
        ->first();

        return view('admin.order.detail',[
            'data' => $data,
        ]);
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data = Order::where('id', $id)->first();
        $user = User::select('id as value', 'nama as label')->latest()->get();
        $produk = Produk::select('id as value', 'nama as label')->latest()->get();

        return view('admin.order.edit',[
            'data' => $data,
            'user' => $user,
            'produk' => $produk
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $rules = [
            'nis' => 'required|numeric|unique:anggota,nis',
            'nama' => 'required|string',
            'jk' => 'required',
            'kelas' => 'required',
            'alamat' => 'required',
        ];

        $pesan = [
            'nis.required' => 'NIS Wajib Diisi!',
            'nis.numeric' => 'NIS Hanya Boleh Angka!',
            'nis.unique' => 'NIS Sudah Terdaftar!',
            'nama.required' => 'Nama Lengkap Wajib Diisi!',
            'jk.required' => 'Bidang Wajib Diisi!',
            'kelas.required' => 'Kelas Wajib Diisi!',
            'alamat.required' => 'Alamat Wajib Diisi!',
        ];


        $validator = Validator::make($request->all(), $rules, $pesan);
        if ($validator->fails()){
            return back()->withErrors($validator->errors());
        }else{
            DB::beginTransaction();
            try{

                $data = Anggota::where('id', $id)->first();
                $data->nis = $request->nis;
                $data->nama = $request->nama;
                $data->jk = $request->jk;
                $data->kelas = $request->kelas;
                $data->hp = $request->hp;
                $data->email = $request->email;
                $data->alamat = $request->alamat;
                $data->status = 'aktif';
                $data->ekskul_id = $request->ekskul_id;
                $data->save();

            }catch(\QueryException $e){
                DB::rollback();
                return response()->json([
                    'fail' => true,
                    'errors' => $e,
                    'pesan' => 'Error Menyimpan Data Anggota',
                ]);
            }

            DB::commit();
            if($request->level_id > 2){
                return back()->withErrors($validator->errors());
            }

            return redirect()->route('anggota.index');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        DB::beginTransaction();
        try{

            $data = Anggota::where('id', $id)->first();
            $data->delete();

        }catch(\QueryException $e){
            DB::rollback();
            return response()->json([
                'fail' => true,
                'errors' => $e,
                'pesan' => 'Gagal Hapus Data!',
            ]);
        }

        DB::commit();
        return response()->json([
            'fail' => false,
            'pesan' => 'Berhasil Hapus Data!',
        ]);
    }

    public function cek(Request $request)
    {
        dd($request->all());
    }

    
    private function getNomor()
    {
        $q = Order::select(DB::raw('MAX(RIGHT(nomor,5)) AS kd_max'));

        $code = 'P';
        $no = 1;
        date_default_timezone_set('Asia/Jakarta');

        if($q->count() > 0){
            foreach($q->get() as $k){
                return $code . date('ym') .'/'.sprintf("%05s", abs(((int)$k->kd_max) + 1));
            }
        }else{
            return $code . date('ym') .'/'. sprintf("%05s", $no);
        }
    }

    public function select(Request $request)
    {
            $cari = $request->searchTerm;
            $user_id = $request->user_id;
            $fetchData = Order::
            when(isset($cari), function($q) use($cari){
                return $q->where('nomor','LIKE',  '%' . $cari .'%');
            })->when(isset($user_id), function($q) use($user_id){
                return $q->where('user_id', $user_id);
            })
            ->orderBy('created_at', 'DESC')->get();

          $data = array();
          foreach($fetchData as $row) {
            $data[] = array("id" =>$row->id, "text"=> $row->nomor);
          }

          return response()->json($data);
    }

    
    public function json(Request $request)
    {
        if(!isset($request->id)){
            $data = Order::where('id', $request->id)->get();
        }else{
            $data = Order::where('id', $request->id)->first();
        }

          return response()->json($data);
    }

    public function status($id, Request $request)
    {
        DB::beginTransaction();
        try{
            $data = Order::where('id', $id)->first();
            $data->status = $request->status;
            $data->save();

            if($request->status == 'Diterima'){
                $today = Carbon::now();
                $date = Collect([
                    'hari' => ucwords($today->translatedFormat('l')),
                    'tgl' => ucwords($this->terbilang((int)$today->translatedFormat('d'))),
                    'bulan' => $today->translatedFormat('F'),
                    'tahun' => ucwords($this->terbilang((int)$today->translatedFormat('Y'))),
                ]);
        
                $pdf = PDF::loadView('pdf.kontrak', [
                    'data' => $data,
                    'date' => $date,
                ], [ ], [
                    'format' => 'A4-P',
                    'margin_top' => '200px',
                ]);

                Mail::to($data->user->email)->send(new OrderStatusMail($data, $pdf->Output('kontrak.pdf')));
            }elseif($request->status == 'Berlangsung'){
                Mail::to($data->user->email)->send(new OrderStatusMail($data));
            }elseif($request->status == 'Selesai'){
                Mail::to($data->user->email)->send(new OrderStatusMail($data));
            }elseif($request->status == 'Ditolak'){
                Mail::to($data->user->email)->send(new OrderStatusMail($data));
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
        ]);
    }
    
    public function pdf($id)
    {
        $data = Order::with(['user','produk'])->where('id', $id)
        ->first();

        $pdf = PDF::loadView('pdf.invoice', [
            'data' => $data,
        ], [ ], [
            'format' => 'A4-P'
        ]);

        return $pdf->stream('Invoice '. $data->nomor .'.pdf');
    }

    public function kontrak($id)
    {
        $data = Order::with(['user','produk'])->where('id', $id)
        ->first();

        // return view('pdf.kontrak', compact('data'));
        $today = Carbon::now();
        $date = Collect([
            'hari' => ucwords($today->translatedFormat('l')),
            'tgl' => ucwords($this->terbilang((int)$today->translatedFormat('d'))),
            'bulan' => $today->translatedFormat('F'),
            'tahun' => ucwords($this->terbilang((int)$today->translatedFormat('Y'))),
        ]);

        $pdf = PDF::loadView('pdf.kontrak', [
            'data' => $data,
            'date' => $date,
        ], [ ], [
            'format' => 'A4-P',
            'margin_top' => '200px',
        ]);

        return $pdf->stream('Kontrak '. $data->nomor .'.pdf');
    }

    private function terbilang($x) {
        $angka = ["", "satu", "dua", "tiga", "empat", "lima", "enam", "tujuh", "delapan", "sembilan", "sepuluh", "sebelas"];
      
        if ($x < 12)
          return " " . $angka[$x];
        elseif ($x < 20)
          return $this->terbilang($x - 10) . " belas";
        elseif ($x < 100)
          return $this->terbilang($x / 10) . " puluh" . $this->terbilang($x % 10);
        elseif ($x < 200)
          return "seratus" . $this->terbilang($x - 100);
        elseif ($x < 1000)
          return $this->terbilang($x / 100) . " ratus" . $this->terbilang($x % 100);
        elseif ($x < 2000)
          return "seribu" . $this->terbilang($x - 1000);
        elseif ($x < 1000000)
          return $this->terbilang($x / 1000) . " ribu" . $this->terbilang($x % 1000);
        elseif ($x < 1000000000)
          return $this->terbilang($x / 1000000) . " juta" . $this->terbilang($x % 1000000);
    }

    public function report(Request $request)
    {
        $tgl = explode(" - ",$request->tgl);
        $data = Order::with(['user'])
        ->whereBetween('tgl', $tgl)
        ->latest()->get();
        $config = [
            'format' => 'A4-L' // Landscape
        ];

        $pdf = PDF::loadView('pdf.order', [
            'data' => $data,
            'tgl' =>$tgl
        ], [ ], $config);

        return $pdf->stream('Laporan Pesanan.pdf');

    }
}
