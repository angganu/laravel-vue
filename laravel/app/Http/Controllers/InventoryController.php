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
        ->get();
        return response()->json( compact('result', 'you') );
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
