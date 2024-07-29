<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DataTables;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Storage;
use Carbon\Carbon;
use App\Models\UserTraining;
use App\Models\User;
use App\Models\Kategori;
use App\Models\Produk;

class ProdukController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Produk::with('kategori')->get();

            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function($row){
                    $btn = '<div class="dropdown">
                        <button type="button" class="btn btn-outline-primary btn-sm dropdown-toggle" id="dropdown-default-outline-primary" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Aksi
                        </button>
                        <div class="dropdown-menu fs-sm" aria-labelledby="dropdown-default-outline-primary" style="">';
                        $btn .= '<a class="dropdown-item" href="'. route('admin.produk.edit', $row->id).'"><i class="si si-note me-1"></i>Ubah</a>';
                        $btn .= '<a class="dropdown-item" href="javascript:void(0)" onclick="hapus('. $row->id.')"><i class="si si-trash me-1"></i>Hapus</a>';
                    $btn .= '</div></div>';
                    return $btn; 
                })
                ->editColumn('tgl_training', function ($row) {
                    $tgl_mulai = Carbon::parse($row->tgl_mulai);
                    $tgl_selesai = Carbon::parse($row->tgl_selesai);
                    if($tgl_mulai->eq($tgl_selesai) || $row->tgl_selesai == null){
                        return $tgl_mulai->translatedformat('d M Y');
                    }else{
                        return $tgl_mulai->translatedformat('d') . ' - '. $tgl_selesai->translatedformat('d M Y');
                    }
                })
                ->editColumn('nama', function ($row) {
                    $dt = '<div class="d-flex">
                    <div class="table-img">
                        <img src="'. $row->foto.'"/>
                    </div>
                        <div class="fw-semibold ms-2 my-auto">
                        '. $row->nama .'
                        </div>
                    </div>';

                    return $dt;
                })
                ->rawColumns(['action', 'nama']) 
                ->make(true);
        }
        return view('admin.produk.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $kategori = Kategori::select(['id as value', 'nama as label'])->orderBy('nama', "ASC")->get()->toArray();

        // dd($kategori);
        return view('admin.produk.create',[
            'kategori' => $kategori
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
            'nama' => 'required',
            'model' => 'required',
        ];

        $pesan = [
            'nama.required' => 'Nama tidak boleh kosong',
            'model.required' => 'Model tidak boleh kosong',
        ];

        $validator = Validator::make($request->all(), $rules, $pesan);
        if ($validator->fails()){
            return back()->withInput()->withErrors($validator->errors());
        }else{
            DB::beginTransaction();
            try{
                // dd($request->all());
                $data = new Produk();
                $data->nama = $request->nama;
                $data->model = $request->model;
                $data->deskripsi = $request->deskripsi;
                $data->kategori_id = $request->kategori_id;
                $data->harga_jam = $request->harga_jam;
                $data->min_sewa = $request->min_sewa;
                $data->harga_harian = $request->harga_harian;
                $data->operator_jam = $request->operator_jam;
                $data->operator_hari = $request->operator_hari;
                $data->spesifikasi = json_encode($request->spek);
                
                if($request->foto){
                    $fileName = time() . '.' . $request->foto->extension();
                    Storage::disk('public')->putFileAs('uploads/produk', $request->foto, $fileName);
                    $data->foto = '/uploads/produk/'.$fileName;
                }
                
                $data->save();

            }catch(\QueryException $e){
                DB::rollback();
                dd($e);
            }

            DB::commit();
            return redirect()->route('admin.produk.index');
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
        $data = Produk::where('id', $id)->first();

        return response()->json($data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data = Produk::where('id', $id)->first();

        $kategori = Kategori::select(['id as value', 'nama as label'])->orderBy('nama', "ASC")->get()->toArray();
        return view('admin.produk.edit',[
            'data' => $data,
            'kategori' =>  $kategori
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
            'nama' => 'required',
            'model' => 'required',
        ];

        $pesan = [
            'nama.required' => 'Nama tidak boleh kosong',
            'model.required' => 'Model tidak boleh kosong',
        ];

        $validator = Validator::make($request->all(), $rules, $pesan);
        if ($validator->fails()){
            return back()->withInput()->withErrors($validator->errors());
        }else{
            DB::beginTransaction();
            try{

                $data = Produk::where('id', $id)->first();
                $data->nama = $request->nama;
                $data->model = $request->model;
                $data->deskripsi = $request->deskripsi;
                $data->kategori_id = $request->kategori_id;
                $data->harga_jam = $request->harga_jam;
                $data->min_sewa = $request->min_sewa;
                $data->harga_harian = $request->harga_harian;
                $data->operator_jam = $request->operator_jam;
                $data->operator_hari = $request->operator_hari;
                $data->spesifikasi = json_encode($request->spek);
                
                if($request->foto){
                    $fileName = time() . '.' . $request->foto->extension();
                    Storage::disk('public')->putFileAs('uploads/produk', $request->foto, $fileName);
                    $data->foto = '/uploads/produk/'.$fileName;
                }

                $data->save();

            }catch(\QueryException $e){
                DB::rollback();
                dd($e);
            }

            DB::commit();
            return redirect()->route('admin.produk.index');
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

            $data = Produk::where('id', $id)->first();
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

    
}
