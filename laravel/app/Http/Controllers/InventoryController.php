<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\Inventory;

class InventoryController extends Controller
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
    public function index()
    {
        $you = auth()->user()->id;
        $result = Inventory::select('inventory.id','inventory.tgl_request as tanggal','inventory.kode_transaksi as kode',
        'employee.nik', 'employee.nama', 'employee.departemen')
        ->leftJoin('employee','inventory.id_employee','employee.id')
        ->whereNull('inventory.deleted_at')
        ->orderBy('id','desc')
        ->get();
        return response()->json( compact('result', 'you') );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'tanggal'    => 'required',
            'id_employee' => 'required',
        ]);
        $data = new Inventory();
        $data->id_employee = $request->input('id_employee');
        $data->tgl_request = date('Y-m-d H:i:s', strtotime($request->input('tanggal')));
        $data->kode_transaksi = 'INV.'.$data->id_employee.'-'.str_pad(rand(1,99999), 5, '0', STR_PAD_LEFT);
        $data->save();
        return response()->json( ['status' => 'success'] );
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $data = Inventory::find($id);
        if($data){
            $data->deleted_at = date('Y-m-d H:i:s');
            $data->save();
        }
        return response()->json( ['status' => 'success'] );
    }
}
