<?php

namespace App\Http\Controllers;

use App\Models\EMRBirth;
use App\Models\HealthFacility;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use DB;
use Hash;
use Illuminate\Support\Facades\Crypt;

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

            $userId = Auth::user()->id;
            $user = User::where('id',$userId)->take(1)->get();
            $province = DB::table("province as p")->select("p.PROCODE","p.PROVINCE","p.PROVINCE_KH")->get();
            if ($user[0]->province_id != 0){
                $province = DB::table("province as p")->where("p.PROCODE",$user[0]->province_id)->select("p.PROCODE","p.PROVINCE","p.PROVINCE_KH")->get();
            }
            return view('emr_birth.index',[
                'user'=>$user,
                'province'=>$province,
                'permission'=>$permission
            ]);
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
            $user = User::where('id',$userId)->take(1)->get();

            $province = DB::table("province as p")->select("p.PROCODE","p.PROVINCE","p.PROVINCE_KH")->get();
//            if ($user[0]->province_id != 0){
//                $province = DB::table("province as p")->where("p.PROCODE",$user[0]->province_id)->select("p.PROCODE","p.PROVINCE","p.PROVINCE_KH")->get();
//            }
            $sex = DB::table("setting_items as s")->where("s.type_id",1)->select("s.item_id","s.name","s.name_kh")->get();
            $birth_info = DB::table("setting_items as s")->where("s.type_id",6)->select("s.item_id","s.name","s.name_kh")->get();
            $birth_type = DB::table("setting_items as s")->where("s.type_id",7)->select("s.item_id","s.name","s.name_kh")->get();
            $attendant_at_delivery = DB::table("setting_items as s")->where("s.type_id",8)->select("s.item_id","s.name","s.name_kh")->get();

            return view('emr_birth.create',[
                'province'=>$province,
                'sex'=>$sex,
                'birth_info'=>$birth_info,
                'birth_type'=>$birth_type,
                'attendant_at_delivery'=>$attendant_at_delivery,
                'user'=>$user
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
            $input['baby_weight'] = $request->baby_weight;
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
            $emr_birth = EMRBirth::where('bid',$request->bid);
            $emr_birth->update($input);
        }
        return Response()->json(array(
            'code' => 0,
        ));
    }

    public function getData(Request $request){

        $province = $request->province;
        $district = $request->district;
        $hf_code = $request->hf_code;
        $baby_name = $request->baby_name;
        $medical_id = $request->medical_id;
        $birth_no = $request->birth_no;
        $results = DB::select("SELECT b.bid,b.birth_no,b.medicalid, b.babyname,t6.name_kh as birth_info,t7.name_kh as birth_type
                ,t1.name_kh as sex,b.dateofbirth,b.time_of_birth,h.HFAC_NAMEKh
            FROM emr_birth b
            INNER JOIN healthfacility h ON b.hfac_code = h.HFAC_CODE
            INNER JOIN opdistrict od ON h.OD_CODE = od.OD_CODE
            INNER JOIN province p ON od.PRO_CODE = p.PROCODE
            INNER JOIN setting_items t7 ON b.typeofbirth = t7.item_id AND t7.type_id = 7
            INNER JOIN setting_items t6 ON b.birth_info = t6.item_id AND t6.type_id = 6
            INNER JOIN setting_items t1 ON b.sex = t1.item_id AND t1.type_id = 1
            WHERE b.is_deleted =0
            AND (p.PROCODE = $province OR $province=0)
            AND (od.OD_CODE = $district OR $district=0)
            AND (h.HFAC_CODE = $hf_code OR $hf_code=0)
            AND b.babyname LIKE '%$baby_name%'
            AND b.medicalid LIKE '%$medical_id%'
            AND b.birth_no LIKE '%$birth_no%'
            ORDER BY b.birth_no DESC LIMIT 100");

        return response()->json($results);
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
                    ,"medicalid", "e.mStreet",'e.abandoned','e.Atdelivery','mothername','motherdofbirth','fathername','fatherdofbirth'
                    ,"e.mHouse", "p1.province_kh as mPCode","dt1.DName_kh as mDCode","e.numofchildalive"
                    ,"c1.CName_kh as mCCode", "v.VName_kh as mVCode"
                    ,DB::raw('TIMESTAMPDIFF(YEAR, motherdofbirth, created_at) as mother_year')
                    ,DB::raw('TIMESTAMPDIFF(MONTH, motherdofbirth, created_at) % 12 as mother_month')
                    ,DB::raw('FLOOR(TIMESTAMPDIFF(YEAR, motherdofbirth, created_at) % 30.4375) as mother_day')
                    ,DB::raw('TIMESTAMPDIFF(YEAR, fatherdofbirth, created_at) as father_year')
                    ,DB::raw('TIMESTAMPDIFF(MONTH, fatherdofbirth, created_at) % 12 as father_month')
                    ,DB::raw('FLOOR(TIMESTAMPDIFF(YEAR, fatherdofbirth, created_at) % 30.4375) as father_day')
                )
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
    public function edit($id)
    {

        $rolde_id = Auth::user()->role_id;
        $module_id = 11;
        $permission = DB::table('module_permissions')->where('role_id', $rolde_id)->where('module_id', $module_id)->first();
        if ($permission->a_update != 1){
            return view('error.error404');
        }
        else{
            $userId = Auth::user()->id;
            $user = User::where('id',$userId)->take(1)->get();

            $province = DB::table("province as p")->select("p.PROCODE","p.PROVINCE","p.PROVINCE_KH")->get();

            $sex = DB::table("setting_items as s")->where("s.type_id",1)->select("s.item_id","s.name","s.name_kh")->get();
            $birth_info = DB::table("setting_items as s")->where("s.type_id",6)->select("s.item_id","s.name","s.name_kh")->get();
            $birth_type = DB::table("setting_items as s")->where("s.type_id",7)->select("s.item_id","s.name","s.name_kh")->get();
            $attendant_at_delivery = DB::table("setting_items as s")->where("s.type_id",8)->select("s.item_id","s.name","s.name_kh")->get();
            $results = DB::select("SELECT b.bid,b.birth_no,b.medicalid, b.babyname,b.birth_info,b.typeofbirth,b.Atdelivery,b.abandoned
                                        ,b.sex,b.dateofbirth,b.time_of_birth,h.HFAC_NAMEKh,od.PRO_CODE,h.OD_CODE,b.hfac_code,b.baby_weight
                                        ,b.mothername,b.motherdofbirth,b.fathername,b.fatherdofbirth,b.numofchildalive
                                        ,b.mPCode,b.mDCode,b.mCCode,b.mVCode,b.mStreet,b.mHouse
                                    FROM emr_birth b
                                    INNER JOIN healthfacility h ON b.hfac_code = h.HFAC_CODE
                                    INNER JOIN opdistrict od ON h.OD_CODE = od.OD_CODE
                                    WHERE b.bid = $id");
            return view('emr_birth.edit',[
                'province'=>$province,
                'sex'=>$sex,
                'birth_info'=>$birth_info,
                'birth_type'=>$birth_type,
                'attendant_at_delivery'=>$attendant_at_delivery,
                'user'=>$user,
                'data'=>$results
            ]);
        }

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
