<?php

namespace App\Http\Controllers;

use App\Models\EMRBirth;
use App\Models\HealthFacility;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use DB;
use Hash;

class EMRBirthController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $rolde_id = Auth::user()->role_id;
        $module_id = 11;
        $permission = DB::table('module_permissions')->where('role_id', $rolde_id)->where('module_id', $module_id)->first();
        if ($permission->a_read != 1){
            return view('error.error404');
        }
        else{

            $data = DB::table("emr_birth as d")
                ->leftJoin("healthfacility as h", function($join){
                    $join->on("d.hfac_code", "=", "h.hfac_code");
                })
                ->leftJoin("province as p1", function($join){
                    $join->on("d.PCode", "=", "p1.procode");
                })
                ->leftJoin("district as dt1", function($join){
                    $join->on("d.DCode", "=", "dt1.dcode");
                })
                ->leftJoin("commune as c1", function($join){
                    $join->on("d.CCode", "=", "c1.ccode");
                })
                ->leftJoin("setting_items as s1", function($join){
                    $join->on("d.birth_info", "=", "s1.item_id")
                        ->where("s1.type_id", "=", 6);
                })
                ->leftJoin("setting_items as s2", function($join){
                    $join->on("d.typeofbirth", "=", "s2.item_id")
                        ->where("s2.type_id", "=", 7);
                })
                ->leftJoin("setting_items as s3", function($join){
                    $join->on("d.Atdelivery", "=", "s3.item_id")
                        ->where("s3.type_id", "=", 8);
                })
                ->leftJoin("setting_items as s4", function($join){
                    $join->on("d.sex", "=", "s4.item_id")
                        ->where("s4.type_id", "=", 1);
                })
                ->where("d.is_deleted",0)
                ->select("d.bid","d.birth_no", "h.hfac_namekh as hfac_label", "s1.name_kh as birth_info",
                    "s2.name_kh as birth_type", "s3.name_kh as attendant_at_delivery","d.babyname",
                    "d.medicalid", "d.dateofbirth", "d.time_of_birth",'s4.name_kh as sex',
                    "p1.province_kh as province_name","dt1.DName_kh as district_name",
                    "c1.CName_kh as commune_name"
                )
                ->orderByRaw('d.bid DESC')
                ->get();
            return view('emr_birth.index',['data'=>$data]);
        }

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $rolde_id = Auth::user()->role_id;
        $module_id = 11;
        $permission = DB::table('module_permissions')->where('role_id', $rolde_id)->where('module_id', $module_id)->first();
        if ($permission->a_create != 1){
            return view('error.error404');
        }
        else{
            $userId = Auth::user()->id;
            $hf_id = User::where('id',$userId)->first(['hf_id'])->hf_id;

            $province = DB::table("province as p")->select("p.PROCODE","p.PROVINCE","p.PROVINCE_KH")->get();
            $sex = DB::table("setting_items as s")->where("s.type_id",1)->select("s.item_id","s.name","s.name_kh")->get();
            $birth_info = DB::table("setting_items as s")->where("s.type_id",6)->select("s.item_id","s.name","s.name_kh")->get();
            $birth_type = DB::table("setting_items as s")->where("s.type_id",7)->select("s.item_id","s.name","s.name_kh")->get();
            $attendant_at_delivery = DB::table("setting_items as s")->where("s.type_id",8)->select("s.item_id","s.name","s.name_kh")->get();

            $hfInfo = DB::table("healthfacility as h")
                ->join("opdistrict as od", function($join){
                    $join->on("h.od_code", "=", "od.od_code");
                })
                ->join("province as p", function($join){
                    $join->on("od.pro_code", "=", "p.procode");
                })
                ->select("h.hfac_label", "h.hfac_name", "h.hfac_namekh", "od.od_name", "od.od_name_kh", "p.province", "p.province_kh")
                ->where("hfac_code", "=", $hf_id)
                ->get();
            return view('emr_birth.create',[
                'hf_info' => $hfInfo,
                'province'=>$province,
                'sex'=>$sex,
                'birth_info'=>$birth_info,
                'birth_type'=>$birth_type,
                'attendant_at_delivery'=>$attendant_at_delivery,
            ]);
        }

    }

    public function Save(Request $request)
    {
        if ($request->bid == 0){

            $userId = Auth::user()->id;

            $birth_no = DB::select( DB::raw("SELECT CONCAT('B',LPAD((SELECT (IFNULL((select max(`bid`) from emr_birth),0)))+1, 10, 0)) as birth_no"));
            $input['hfac_code'] = $request->hf_code;
            $input['hfac_label'] = $request->hf_code;
            $input['birth_no'] = $birth_no[0]->birth_no;
            $input['medicalid'] = $request->medicalid;
            $input['birth_info'] = $request->birth_info;
            $input['typeofbirth'] = $request->birth_type;
            $input['Atdelivery'] = $request->attendant_at_delivery;
            $input['abandoned'] = $request->abandoned_baby;
            $input['babyname'] = $request->baby_name;
            $input['sex'] = $request->sex;
            $input['dateofbirth'] = $request->date_of_birth;
            $input['time_of_birth'] = $request->time_of_birth;
            $input['mothername'] = $request->mother_name;
            $input['motherdofbirth'] = $request->mother_date_of_birth;
            $input['fathername'] = $request->father_name;
            $input['fatherdofbirth'] = $request->father_date_of_birth;
            $input['numofchildalive'] = $request->numofchildalive;
            $input['mPCode'] = $request->mother_province;
            $input['mDCode'] = $request->mother_district;
            $input['mCCode'] = $request->mother_commune;
            $input['mVCode'] = $request->mother_village;
            $input['mStreet'] = $request->mother_street;
            $input['mHouse'] = $request->mother_house;
            $input['creation_user'] = Auth::user()->id;

            EMRBirth::create($input);
        }
        else{
            $input = $request->all();
            $emr_death = EMRDeath::where('death_id',$request->death_id);
            $emr_death->update($input);
        }
        return Response()->json(array(
            'code' => 0,
        ));
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
     * @param  \App\Models\EMRBirth  $eMRBirth
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $rolde_id = Auth::user()->role_id;
        $module_id = 11;
        $permission = DB::table('module_permissions')->where('role_id', $rolde_id)->where('module_id', $module_id)->first();
        if ($permission->a_read != 1){
            return view('error.error404');
        }
        else{
            $hf_id = EMRBirth::where("bid",$id)->first(['hfac_code'])->hfac_code;

            $hfInfo = DB::table("healthfacility as h")
                ->join("opdistrict as od", function($join){
                    $join->on("h.od_code", "=", "od.od_code");
                })
                ->join("province as p", function($join){
                    $join->on("od.pro_code", "=", "p.procode");
                })
                ->select("h.hfac_label", "h.hfac_name", "h.hfac_namekh", "od.od_name", "od.od_name_kh", "p.province", "p.province_kh")
                ->where("hfac_code", "=", $hf_id)
                ->get();

            $data = DB::table("emr_birth as e")
                ->leftJoin("province as p1", function($join){
                    $join->on("e.mPCode", "=", "p1.procode");
                })
                ->leftJoin("district as dt1", function($join){
                    $join->on("e.mDCode", "=", "dt1.dcode");
                })
                ->leftJoin("commune as c1", function($join){
                    $join->on("e.mCCode", "=", "c1.ccode");
                })
                ->leftJoin("village as v", function($join){
                    $join->on("e.mVCode", "=", "v.vcode");
                })
                ->select("e.bid","e.birth_no","e.babyname", "e.birth_info", "e.typeofbirth"
                    ,"e.dateofbirth", "e.time_of_birth", "e.sex", "e.abandoned"
                    ,"medicalid", "e.mStreet",'e.abandoned'
                    ,"e.mHouse", "p1.province_kh as mPCode","dt1.DName_kh as mDCode",
                    "c1.CName_kh as mCCode", "v.VName_kh as mVCode")
                ->where("e.bid", "=", $id)
                ->get();

            $province = DB::table("province as p")->select("p.PROCODE","p.PROVINCE","p.PROVINCE_KH")->get();
            $sex = DB::table("setting_items as s")->where("s.type_id",1)->select("s.item_id","s.name","s.name_kh")->get();
            $birth_info = DB::table("setting_items as s")->where("s.type_id",6)->select("s.item_id","s.name","s.name_kh")->get();
            $birth_type = DB::table("setting_items as s")->where("s.type_id",7)->select("s.item_id","s.name","s.name_kh")->get();
            $attendant_at_delivery = DB::table("setting_items as s")->where("s.type_id",8)->select("s.item_id","s.name","s.name_kh")->get();

            return view('emr_birth.print',[
                'data' => $data,
                'hf_info'=>$hfInfo,
                'birth_info'=>$birth_info,
                'birth_type'=>$birth_type,
                'sex'=>$sex,
                'province'=>$province,
                'attendant_at_delivery'=>$attendant_at_delivery]);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\EMRBirth  $eMRBirth
     * @return \Illuminate\Http\Response
     */
    public function edit(EMRBirth $eMRBirth)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\EMRBirth  $eMRBirth
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, EMRBirth $eMRBirth)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\EMRBirth  $eMRBirth
     * @return \Illuminate\Http\Response
     */
    public function destroy(EMRBirth $eMRBirth)
    {
        //
    }
}
