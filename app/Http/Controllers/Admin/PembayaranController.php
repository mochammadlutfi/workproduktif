<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Routing\Controller;
use Carbon\Carbon;
use Storage;
use DataTables;

use App\Models\User;
use App\Models\Payment;
use App\Models\Order;

class PembayaranController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $order_id = $request->order_id;
            $data = Payment::with(['order' => function($q){
                return $q->with('user');
            }])
            ->when($order_id, function($q, $order_id){
                return $q->where('order_id', $order_id);
            })
            ->orderBy('id', 'DESC')->get();

            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function($row){
                    $btn = '<a class="btn btn-primary btn-sm" href="'. route('admin.payment.show', $row->id) .'">Detail</a>';
                    return $btn; 
                })
                ->editColumn('tgl', function ($row) {
                    $tgl =  Carbon::parse($row->tgl)->translatedFormat('d F Y');
                    return $tgl;
                })
                ->editColumn('created_at', function ($row) {
                    $tgl = Carbon::parse($row->created_at);

                    return $tgl->translatedFormat('d M Y');
                })
                ->editColumn('jumlah', function ($row) {
                    return 'Rp '.number_format($row->jumlah,0,',','.');
                })
                ->editColumn('status', function ($row) {
                    if($row->status == 'pending'){
                        return '<span class="badge bg-danger">Menunggu Konfirmasi</span>';
                    }else if($row->status == 'terima'){
                        return '<span class="badge bg-success">Diterima</span>';
                    }else if($row->status == 'tolak'){
                        return '<span class="badge bg-danger">Ditolak</span>';
                    }
                })
                ->rawColumns(['action', 'status', 'jumlah']) 
                ->make(true);
        }
        return view('admin.pembayaran.index');
    }

    public function create(Request $request)
    {
        return view('admin.pembayaran.create');
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
        // $booking = Booking::where('id', $request->booking_id)
        // ->withSum([ 'bayar' => fn ($query) => $query->where('status', 'setuju')], 'jumlah')
        // ->first();
        // $max = $booking->total_bayar - $booking->bayar_sum_jumlah;
        $rules = [
            'tgl' => 'required',
            'jumlah' => 'required',
            'bukti' => 'required',
        ];

        $pesan = [
            'tgl.required' => 'Tanggal Bayar Wajib Diisi!',
            'jumlah.required' => 'Jumlah Wajib Diisi!',
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
                $data->order_id = $request->order_id;
                $data->bank = $request->bank;
                $data->pengirim = $request->pengirim;
                $data->tgl = Carbon::parse($request->tgl);
                $data->jumlah = $request->jumlah;
                $data->status = $request->status;

                if($request->bukti){
                    $fileName = time() . '.' . $request->bukti->extension();
                    Storage::disk('public')->putFileAs('uploads/pembayaran', $request->bukti, $fileName);
                    $data->bukti = '/uploads/pembayaran/'.$fileName;
                }
                $data->save();

            }catch(\QueryException $e){
                DB::rollback();
                return response()->json([
                    'fail' => true,
                    'pesan' => $e,
                ]);
            }

            DB::commit();
            return redirect()->route('admin.payment.show', $data->id);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data = Payment::where('id', $id)->first();

        return view('admin.pembayaran.show',[
            'data' => $data
        ]);
    }

    
    public function status($id, Request $request)
    {
        DB::beginTransaction();
        try{
            $data = Payment::where('id', $id)->first();
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

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data = Ekskul::where('id', $id)->first();
        $pembina = User::where('level', 'pembina')->orderBy('nama', 'ASC')->get();
        return view('ekskul.edit',[
            'pembina' => $pembina,
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
        // dd($request->all());
        $rules = [
            'nama' => 'required',
            'pembina_id' => 'required',
            'deskripsi' => 'required',
            'tempat' => 'required',
            'jadwal' => 'required',
            'mulai' => 'required',
            'selesai' => 'required',
        ];

        $pesan = [
            'nama.required' => 'Nama Wajib Diisi!',
            'pembina_id.required' => 'Pembina Wajib Diisi!',
            'deskripsi.required' => 'Deskripsi Wajib Diisi!',
            'tempat.required' => 'Tempat Wajib Diisi!',
            'mulai.required' => 'Jam Mulai Wajib Diisi!',
            'selesai.required' => 'Jam Selesai Wajib Diisi!',
        ];


        $validator = Validator::make($request->all(), $rules, $pesan);
        if ($validator->fails()){
            return back()->withInput()->withErrors($validator->errors());
        }else{
            DB::beginTransaction();
            try{

                $data = Ekskul::where('id', $id)->first();
                $data->nama = $request->nama;
                $data->pembina_id = $request->pembina_id;
                $data->deskripsi = $request->deskripsi;
                $data->tempat = $request->tempat;
                $data->jadwal = json_encode($request->jadwal);
                $data->mulai = $request->mulai;
                $data->selesai = $request->selesai;
                $data->status = $request->status;
                if($request->foto){
                    if(!empty($data->foto)){
                        $cek = Storage::disk('public')->exists($data->foto);
                        if($cek)
                        {
                            Storage::disk('public')->delete($data->foto);
                        }
                    }
                    $fileName = time() . '.' . $request->foto->extension();
                    Storage::disk('public')->putFileAs('uploads/ekskul', $request->foto, $fileName);
                    $data->foto = '/uploads/ekskul/'.$fileName;
                }
                $data->save();

            }catch(\QueryException $e){
                DB::rollback();
                back()->withInput()->withErrors($validator->errors());
            }

            DB::commit();
            return redirect()->route('ekskul.index');
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

            $data = UserTraining::where('id', $id)->first();
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

    private function getNumber()
    {
        $q = Booking::select(DB::raw('MAX(RIGHT(nomor,5)) AS kd_max'));

        $code = 'BKN/';
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
}
