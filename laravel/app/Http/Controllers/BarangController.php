<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\Barang;

class BarangController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $you = auth()->user()->id;
        $search = ($request->search)? $request->search:'';
        $result = Barang::select('barang.id', 'barang.kode_barang', 'barang.nama_barang', 'barang.stock',
        'inventory_lokasi.nama_lokasi as lokasi', 'barang_satuan.nama_satuan as satuan')
        ->leftJoin('inventory_lokasi','barang.id_lokasi','inventory_lokasi.id')
        ->leftJoin('barang_satuan','barang.id_satuan','barang_satuan.id')
        ->where('barang.kode_barang', 'like', "%$search%")
        ->whereNull('barang.deleted_at')
        ->get();
        return response()->json( compact('result', 'you') );
    }

}
