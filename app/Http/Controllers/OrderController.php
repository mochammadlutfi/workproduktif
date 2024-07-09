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

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Booking::where('user_id', auth()->guard('web')->user()->id)
            ->orderBy('id', 'DESC')
            ->get();

            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function($row){
                    $btn = '<a href="'. route('booking.show', $row->id) .'" class="btn btn-primary btn-sm">Detail</a>';
                    return $btn; 
                })
                ->editColumn('created_at', function ($row) {
                    return Carbon::parse($row->created_at)->translatedFormat('d F Y');
                })
                ->editColumn('tgl', function ($row) {
                    $tgl =  Carbon::parse($row->tgl)->translatedFormat('d F Y');

                    return $tgl . '<br>' . $row->mulai . " - " . $row->selesai .' WIB';
                })
                ->editColumn('status', function ($row) {
                    if($row->status == 'belum bayar'){
                        return '<span class="badge bg-danger">Belum Bayar</span>';
                    }else if($row->status == 'sebagian'){
                        return '<span class="badge bg-warning">Sebagian</span>';
                    }else if($row->status == 'pending'){
                        return '<span class="badge bg-primary">Menunggu Konfirmasi</span>';
                    }else if($row->status == 'lunas'){
                        return '<span class="badge bg-success">Lunas</span>';
                    }else if($row->status == 'batal'){
                        return '<span class="badge bg-secondary">Batal</span>';
                    }
                })
                ->rawColumns(['action', 'status', 'tgl']) 
                ->make(true);
        }

        return view('landing.order.index');
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
        $rules = [
            'tgl' => 'required',
            'lama' => 'required',
            'waktu' => 'required',
        ];

        $pesan = [
            'tgl.required' => 'Tanggal Main Wajib Diisi!',
            'lama.required' => 'Lama Main Wajib Diisi!',
            'waktu.required' => 'Waktu Main Wajib Diisi!',
        ];

        $validator = Validator::make($request->all(), $rules, $pesan);
        if ($validator->fails()){
            return back()->withInput()->withErrors($validator->errors());
        }else{
            DB::beginTransaction();
            try{
                $tgl =  Carbon::parse($request->tgl.' '.$request->waktu);
                // dd($test);
                $data = new Booking();
                $data->nomor = $this->getNumber();
                $data->tgl = Carbon::parse($request->tgl);
                $data->lama = $request->lama;
                $data->mulai = $tgl->format('H:i');
                $data->selesai = $tgl->addHour($request->lama)->format('H:i');
                $data->status = $request->status;
                $data->harga = 100000;
                $data->diskon = $request->diskon;
                $data->total = $request->total;
                $data->status = 'belum bayar';
                $data->total_bayar = $request->total_bayar;
                $data->user_id = auth()->guard('web')->user()->id;
                $data->save();

            }catch(\QueryException $e){
                DB::rollback();
                dd($e);
            }

            DB::commit();
            return redirect()->route('booking.show', $data->id);
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
        $data = Booking::where('id', $id)
        ->withSum([ 'bayar' => fn ($query) => $query->where('status', 'setuju')], 'jumlah')
        ->first();

        return view('landing.booking.show',[
            'data' => $data
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

    public function anggota($id, Request $request)
    {
        if ($request->ajax()) {

            $data = DB::table("anggota_eskul as a")
            ->select('a.*', 'b.nis', 'b.nama', 'b.kelas', 'b.hp', 'b.email', 'b.jk', 'b.alamat', 'c.nama as ekskul')
            ->join("anggota as b", "b.id", "=", "a.anggota_id")
            ->join("ekskul as c", "c.id", "=", "a.ekskul_id")
            ->where('a.ekskul_id', $id)
            ->get();

            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function($row){
                    $actionBtn = '<a href="'.route('anggota.show', $row->id).'" class="edit btn btn-primary btn-sm">Detail</a>';
                    return $actionBtn;
                })
                ->editColumn('created_at', function ($row) {
                    return Carbon::parse($row->created_at)->translatedFormat('d F Y');
                })
                ->editColumn('status', function ($row) {
                    if($row->status == 'draft'){
                        return '<span class="badge bg-warning">Menunggu Konfirmasi</span>';
                    }else if($row->status == 'aktif'){
                        return '<span class="badge bg-success">Aktif</span>';
                    }else if($row->status == 'tolak'){
                        return '<span class="badge bg-success">Ditolak</span>';
                    }else{
                        return '<span class="badge bg-secondary">Keluar</span>';
                    }
                })
                ->rawColumns(['action', 'status']) 
                ->make(true);
        }
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
