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

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function user(Request $request)
    {
        $data = Training::whereHas('user', function($q){
            return $q->where('user_id', );
        })->get();
        if ($request->ajax()) {
            $query = UserTraining::with('training')->where('user_id', auth()->guard('web')->user()->id)
            ->get();

            return DataTables::of($query)
                ->addIndexColumn()
                ->addColumn('action', function($row){
                    // $btn = '<div class="dropdown">
                    //     <button type="button" class="btn btn-outline-primary btn-sm dropdown-toggle" id="dropdown-default-outline-primary" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    //         Aksi
                    //     </button>
                    //     <div class="dropdown-menu fs-sm" aria-labelledby="dropdown-default-outline-primary" style="">';
                    //     $btn .= '<a class="dropdown-item" href="'. route('admin.training.edit', $row->id).'"><i class="si si-note me-1"></i>Ubah</a>';
                    //     $btn .= '<a class="dropdown-item" href="javascript:void(0)" onclick="hapus('. $row->id.')"><i class="si si-trash me-1"></i>Hapus</a>';
                    // $btn .= '</div></div>';
                    $btn = '<button type="button" class="btn btn-sm btn-danger"><i class="fa fa-eye me-1"></i>Detail</button>';

                    return $btn; 
                })
                ->editColumn('tgl_daftar', function ($row) {
                    $tgl = Carbon::parse($row->created_at);

                    return $tgl->translatedFormat('d M Y');
                })
                ->editColumn('harga', function ($row) {
                    $hrg = 'Rp ';
                    if($row->training->harga){
                        $hrg .= number_format($row->training->harga,0,',','.');
                    }else{
                        $hrg = 'Gratis';
                    }

                    return $hrg;
                })
                ->editColumn('training.nama', function ($row) {
                    $tgl_mulai = Carbon::parse($row->training->tgl_mulai);
                    $tgl_selesai = Carbon::parse($row->training->tgl_selesai);
                    if($tgl_mulai->isSameMonth($tgl_selesai) || $row->training->tgl_selesai == null){
                        $tgl = $tgl_mulai->translatedformat('d M Y');
                    }else{
                        $tgl = $tgl_mulai->translatedformat('d') . ' - '. $tgl_selesai->translatedformat('d M Y');
                    }
                    $ret = $row->training->nama;
                    $ret .= '<br/>';
                    $ret .= $tgl;
                    return $ret;

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
                ->editColumn('training.status', function ($row) {
                    if($row->training->status == 'draft'){
                        return '<span class="badge bg-warning">Draft</span>';
                    }else if($row->training->status == 'buka'){
                        return '<span class="badge bg-primary">Buka</span>';
                    }else{
                        return '<span class="badge bg-danger">Tutup</span>';
                    }
                })
                ->rawColumns(['action','status', 'training.nama', 'training.status']) 
                ->make(true);
        }


        return view('landing.training.user',[
            'data' => $data
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function certificate($id, Request $request)
    {
        $user = auth()->guard('web')->user();
        $data = Training::where('id', $id)->first();

        
        $register = UserTraining::where('user_id', $user->id)
        ->where('training_id', $data->id)->first();

        $config = [
            'format' => 'A4-L'
        ];
        $pdf = PDF::loadView('reports.certificate', [
            'data' => $data,
            'register' => $register,
            'user' => $user
        ], [ ], $config);

        return $pdf->stream('Sertifikat '. $data->nama.'.pdf');
    }

    private function getNumber($training)
    {
        $q = UserTraining::select(DB::raw('MAX(RIGHT(nomor,5)) AS kd_max'));

        $code = $training;
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
