<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\Employee;

class EmployeeController extends Controller
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
        $result = Employee::select('employee.id', 'employee.nik', 'employee.nama', 'employee.departemen')
        ->where('nik', 'like', "%$search%")
        ->whereNull('deleted_at')
        ->get();
        return response()->json( compact('result', 'you') );
    }

}
