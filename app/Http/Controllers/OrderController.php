<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Storage;
use DataTables;

use App\Models\User;
use App\Models\Order;
use App\Models\Payment;
use PDF;
class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        
        $data = Order::where('user_id', auth()->guard('web')->user()->id)
        ->orderBy('id', 'DESC')
        ->get();

        return view('landing.order.index',[
            'data' => $data,
        ]);
    }


    public function payment($id, Request $request)
    {
        $data = Order::where('id', $id)
        ->first();
        return view('landing.order.pembayaran',[
            'data' => $data
        ]);
    }

    public function paymentShow($id, $payment_id)
    {
        $data = Payment::where('id', $payment_id)->first();

        return view('landing.order.pembayaran_show', [
            'data' => $data
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
        // dd($request->all());
        // $rules = [
        //     'tgl' => 'required',
        //     'lama' => 'required',
        //     'waktu' => 'required',
        // ];

        // $pesan = [
        //     'tgl.required' => 'Tanggal Main Wajib Diisi!',
        //     'lama.required' => 'Lama Main Wajib Diisi!',
        //     'waktu.required' => 'Waktu Main Wajib Diisi!',
        // ];

        // $validator = Validator::make($request->all(), $rules, $pesan);
        // if ($validator->fails()){
        //     return back()->withInput()->withErrors($validator->errors());
        // }else{
            DB::beginTransaction();
            try{

                $data = new Order();
                $data->nomor = $this->getNumber();
                $data->produk_id = $request->produk_id;
                $data->tgl = Carbon::parse($request->tgl);
                $data->lama = $request->lama;
                $data->qty = $request->qty;
                $data->harga_unit = $request->harga_unit;
                $data->harga_operator = $request->harga_operator;
                $data->lokasi = $request->lokasi;
                $data->total = $request->total;
                $data->user_id = auth()->guard('web')->user()->id;
                $data->status = 'Pending';
                $data->save();

            }catch(\QueryException $e){
                DB::rollback();
                dd($e);
            }

            DB::commit();
            return redirect()->route('order.show', $data->id);
        // }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data = Order::where('id', $id)
        ->first();
        // dd($data->toArray());

        return view('landing.order.show',[
            'data' => $data
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
            'tgl' => 'required',
            'jumlah' => 'required',
            'bank' => 'required',
            'bukti' => 'required',
        ];

        $pesan = [
            'tgl.required' => 'Tanggal Bayar Wajib Diisi!',
            'jumlah.required' => 'Jumlah Wajib Diisi!',
            'bank.required' => 'Bank Wajib Diisi!',
            // 'jumlah.max' => 'Jumlah Pembayaran Maksimal Rp '.number_format($max,0,',','.'),
            'bukti.required' => 'Bukti Pembayaran Wajib Diisi!',
        ];


        $validator = Validator::make($request->all(), $rules, $pesan);
        if ($validator->fails()){
            return back()->withInput()->withErrors($validator->errors());
        }else{
            DB::beginTransaction();
            try{

                $data = new Payment();
                $data->order_id = $id;
                $data->bank = $request->bank;
                $data->pengirim = $request->pengirim;
                $data->tgl = Carbon::parse($request->tgl);
                $data->jumlah = $request->jumlah;
                $data->status = 'pending';

                if($request->bukti){
                    $fileName = time() . '.' . $request->bukti->extension();
                    Storage::disk('public')->putFileAs('uploads/pembayaran', $request->bukti, $fileName);
                    $data->bukti = '/uploads/pembayaran/'.$fileName;
                }
                $data->save();

            }catch(\QueryException $e){
                DB::rollback();
                back()->withInput()->withErrors($validator->errors());
            }

            DB::commit();
            return redirect()->route('order.show', $id);
        }
    }

    public function upload(Request $request, $id)
    {
        $rules = [
            'file' => 'required',
        ];

        $pesan = [
            'file.required' => 'Tanggal Bayar Wajib Diisi!',
        ];


        $validator = Validator::make($request->all(), $rules, $pesan);
        if ($validator->fails()){
            return back()->withInput()->withErrors($validator->errors());
        }else{
            DB::beginTransaction();
            try{

                $data = Order::where('id', $id)->first();
                if($request->file){
                    $fileName = time() . '.' . $request->file->extension();
                    Storage::disk('public')->putFileAs('uploads/kontrak', $request->file, $fileName);
                    $data->kontrak = '/uploads/kontrak/'.$fileName;
                }
                $data->save();

            }catch(\QueryException $e){
                DB::rollback();
                back()->withInput()->withErrors($validator->errors());
            }

            DB::commit();
            return redirect()->route('order.show', $id);
        }
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Perbaikan  $perbaikan
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        DB::beginTransaction();
        try{

            $data = Ekskul::where('id', $id)->first();
            $cek = Storage::disk('public')->exists($data->foto);
            if($cek)
            {
                Storage::disk('public')->delete($data->foto);
            }
            $data->delete();

        }catch(\QueryException $e){
            DB::rollback();
            return response()->json([
                'fail' => true,
                'errors' => $e,
                'pesan' => 'Data Gagal Dihapus!',
            ]);
        }

        DB::commit();
        return response()->json([
            'fail' => false,
            'pesan' => 'Data Berhasil Dihapus!',
        ]);
    }

    
    public function cek(Request $request)
    {
        // dd($request->all());
        $date = Carbon::createFromFormat('Y-m-d H:i', $request->tgl. ' '. $request->waktu);
        $end =  Carbon::createFromFormat('Y-m-d H:i', $request->tgl. ' '. $request->waktu)->addHour($request->durasi);
        $time_start = $date->format('Y-m-d H:i:s');
        $time_end = $end->format('Y-m-d H:i:s');

        $sewa = Booking::whereDate('tgl', $request->tgl)->OrderBy('mulai', 'ASC')->get(); 

        // dd($sewa);
        if (strtotime($request->waktu) >= strtotime('06:00:00') && strtotime($request->waktu) < strtotime('15:00:00')) {
            $harga = 100000;
        }elseif (strtotime($request->waktu) >= strtotime('15:00:00') && strtotime($request->waktu) < strtotime('18:00:00')) {
            $harga = 120000;
        }else{
            $harga = 150000;
        }
        
        foreach ($sewa as $s) {
            $event_start = strtotime($s->mulai);
            $event_end = strtotime($s->selesai);
            $requested_start = strtotime($time_start);
            $requested_end = strtotime($time_end);

            if (($requested_start >= $event_start && $requested_start < $event_end) || 
                ($requested_end > $event_start && $requested_end <= $event_end) || 
                ($requested_start <= $event_start && $requested_end >= $event_end)) {
                    return response()->json([
                        'fail' => true,
                        'harga' => $harga,
                    ]);
            }
        }
        return response()->json([
            'fail' => false,
            'harga' => $harga,
        ]);
    }

    
    private function getNumber()
    {
        $q = Order::select(DB::raw('MAX(RIGHT(nomor,5)) AS kd_max'));

        $code = 'PSN/';
        $no = 1;
        date_default_timezone_set('Asia/Jakarta');

        if($q->count() > 0){
            foreach($q->get() as $k){
                return $code .sprintf("%05s", abs(((int)$k->kd_max) + 1));
            }
        }else{
            return $code . sprintf("%05s", $no);
        }
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
            'tahun' => ucwords($this->terbilang($today->translatedFormat('Y'))),
        ]);

        $pdf = PDF::loadView('pdf.kontrak', [
            'data' => $data,
            'date' => $date,
        ], [ ], [
            'format' => 'A4-P',
            'margin_top' => '200px',
        ]);

        return $pdf->stream('Invoice '. $data->nomor .'.pdf');
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

}
