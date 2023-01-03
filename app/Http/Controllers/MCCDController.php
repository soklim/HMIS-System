<?php

namespace App\Http\Controllers;

use App\Models\MCCD;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use DB;
use Hash;
class MCCDController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $rolde_id = Auth::user()->role_id;
        $module_id = 15;
        $permission = DB::table('module_permissions')->where('role_id', $rolde_id)->where('module_id', $module_id)->first();
        if ($permission->a_read != 1){
            return view('error.error404');
        }
        else{

            $userId = Auth::user()->id;
            return view('mccd.index',[
                'permission'=>$permission,
            ]);
        }

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $rolde_id = Auth::user()->role_id;
        $module_id = 15;
        $permission = DB::table('module_permissions')->where('role_id', $rolde_id)->where('module_id', $module_id)->first();
        if ($permission->a_read != 1){
            return view('error.error404');
        }
        else{

            $userId = Auth::user()->id;
            $data = DB::select("CALL SP_MCCD_MEDICAL('')");
            $death = DB::table("emr_death as d")
                ->select("d.issue_no","d.death_id","d.deceased_name")
                ->where("d.is_deleted",0)
                ->get();
            return view('mccd.create',[
                'permission'=>$permission,
                'data'=>$data,
                'death'=>$death
            ]);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\MCCD  $mCCD
     * @return \Illuminate\Http\Response
     */
    public function show(MCCD $mCCD)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\MCCD  $mCCD
     * @return \Illuminate\Http\Response
     */
    public function edit(MCCD $mCCD)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\MCCD  $mCCD
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, MCCD $mCCD)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\MCCD  $mCCD
     * @return \Illuminate\Http\Response
     */
    public function destroy(MCCD $mCCD)
    {
        //
    }
}
