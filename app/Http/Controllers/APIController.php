<?php

namespace App\Http\Controllers;

use App\Models\API;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use DB;
use Hash;

class APIController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $rolde_id = Auth::user()->role_id;
        $module_id = 14;
        $permission = DB::table('module_permissions')->where('role_id', $rolde_id)->where('module_id', $module_id)->first();
        if ($permission->a_read != 1){
            return view('error.error404');
        }
        else{
            $api_url = DB::table("api_url as u")->select("u.*")->get();
            return view('api.index',['api_url' => $api_url]);
        }
    }

    public function Save(Request $request)
    {
        if ($request->id == 0){
            $input['api_id'] = $request->api_id;
            $input['username'] = $request->username ;
            $input['api_key'] = $request->api_key ;
            API::create($input);
        }
        else{
            $input = $request->all();
            $data = API::find($request->id);
            $data->update($input);
        }
        return Response()->json(array(
            'code' => 0,
        ));
    }
    public function  getData(){

        $data = DB::table('api_users as a')
            ->join('api_url as u', 'a.api_id', '=', 'u.id')
            ->select('a.*', 'u.*')
            ->orderByRaw('a.id ASC')
            ->get();
        return response()->json($data->toArray());

    }

    public function Death_Notification(Request $request){

        if($request->url_id == null || $request->death_id == null || $request->api_key == null || $request->url_id == "" || $request->death_id == "" || $request->api_key == ""){
            return response()->json(['error'=>'Invalid parameter']);
        }
        else{
            $count_api = DB::table('api_users')->where("id",$request->url_id)->where("api_key",$request->api_key)->count();

            if ($count_api == 0){
                return response()->json(['error'=>'Invalid API Key']);
            }
            else{
                $data = DB::table("emr_death as d")
                    ->leftJoin("healthfacility as h", function($join){
                        $join->on("d.hmis_code", "=", "h.hfac_code");
                    })
                    ->leftJoin("province as p1", function($join){
                        $join->on("d.deceased_province_code", "=", "p1.procode");
                    })
                    ->leftJoin("district as dt1", function($join){
                        $join->on("d.deceased_district_code", "=", "dt1.dcode");
                    })
                    ->leftJoin("commune as c1", function($join){
                        $join->on("d.deceased_commune_code", "=", "c1.ccode");
                    })
                    ->leftJoin("village as v", function($join){
                        $join->on("d.deceased_village", "=", "v.vcode");
                    })
                    ->leftJoin("setting_items as s1", function($join){
                        $join->on("d.death_info", "=", "s1.item_id")
                            ->where("s1.type_id", "=", 2);
                    })
                    ->leftJoin("setting_items as s2", function($join){
                        $join->on("d.death_type", "=", "s2.item_id")
                            ->where("s2.type_id", "=", 3);
                    })
                    ->leftJoin("setting_items as s3", function($join){
                        $join->on("d.sex", "=", "s3.item_id")
                            ->where("s3.type_id", "=", 1);
                    })
                    ->leftJoin("setting_items as s4", function($join){
                        $join->on("d.married_status", "=", "s4.item_id")
                            ->where("s4.type_id", "=", 4);
                    })
                    ->leftJoin("healthfacility as hf", function($join){
                        $join->on("d.hmis_code", "=", "hf.HFAC_CODE");
                    })
                    ->where("d.death_id", $request->death_id)
                    ->select("d.death_id","d.issue_no", "h.hfac_namekh as hfac_label", "s1.name_kh as death_info",
                        "s2.name_kh as death_type", "s3.name_kh as sex", "s4.name_kh as married_status","d.deceased_name",
                        "d.medical_file_id", "d.date_of_death", "d.time_of_death",
                        "p1.province_kh as deceased_province_code","dt1.DName_kh as deceased_district_code",
                        "c1.CName_kh as deceased_commune_code", "v.VName_kh as deceased_village",
                        "d.deceased_street", "d.deceased_house",
                    )
                    ->get();
                return response()->json($data->toArray());
            }
        }

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
     * @param  \App\Models\API  $aPI
     * @return \Illuminate\Http\Response
     */
    public function show(API $aPI)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\API  $aPI
     * @return \Illuminate\Http\Response
     */
    public function edit(API $aPI)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\API  $aPI
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, API $aPI)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\API  $aPI
     * @return \Illuminate\Http\Response
     */
    public function destroy(API $aPI)
    {
        //
    }
}
