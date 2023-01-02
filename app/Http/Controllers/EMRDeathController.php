<?php

namespace App\Http\Controllers;

use App\Models\EMRDeath;
use App\Models\HealthFacility;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use DB;
use Hash;
use Spatie\Permission\Models\Permission;

class EMRDeathController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $rolde_id = Auth::user()->role_id;
        $module_id = 12;
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

            $module = DB::table("modules as m")
                ->join("group_modules as g", function($join){
                    $join->on("m.group_id", "=", "g.id");
                })
                ->select("g.name as group_module_name", "m.name as module_name")
                ->where("m.id", "=", $module_id)
                ->get();

            return view('emr_death.index',[
                'user'=>$user,
                'province'=>$province,
                'permission'=>$permission,
                'module' => $module
            ]);

        }

    }
    public function edit($id)
    {
        $rolde_id = Auth::user()->role_id;
        $module_id = 12;
        $permission = DB::table('module_permissions')->where('role_id', $rolde_id)->where('module_id', $module_id)->first();
        if ($permission->a_update != 1){
            return view('error.error404');
        }
        else{
            $hf_id = EMRDeath::where("death_id",$id)->first(['hmis_code'])->hmis_code;
            $hfInfo = DB::table("healthfacility as h")
                ->join("opdistrict as od", function($join){
                    $join->on("h.od_code", "=", "od.od_code");
                })
                ->select("h.hfac_label", "h.OD_CODE", "od.PRO_CODE")
                ->where("hfac_code", "=", $hf_id)
                ->get();

            $data = DB::table("emr_death as e")
                ->select("e.death_id","e.deceased_name", "e.death_info", "e.death_type", "e.date_of_birth", "e.date_of_death", "e.time_of_death", "e.sex", "e.married_status"
                    , "medical_file_id", "e.deceased_province_code", "e.deceased_district_code", "e.deceased_commune_code", "e.deceased_village", "e.deceased_street"
                    ,"od.PRO_CODE","od.OD_CODE","h.hfac_code"
                    , "e.deceased_house","e.age","e.is_baby")
                ->join("healthfacility as h", function($join){
                    $join->on("e.hmis_code", "=", "h.HFAC_CODE");
                })
                ->join("opdistrict as od", function($join){
                    $join->on("h.od_code", "=", "od.od_code");
                })
                ->where("e.death_id", "=", $id)
                ->get();
            $userId = Auth::user()->id;
            $user = User::where('id',$userId)->take(1)->get();
            $province = DB::table("province as p")->select("p.PROCODE","p.PROVINCE","p.PROVINCE_KH")->get();
            if ($user[0]->province_id != 0){
                $province = DB::table("province as p")->where("p.PROCODE",$user[0]->province_id)->select("p.PROCODE","p.PROVINCE","p.PROVINCE_KH")->get();
            }

            $module = DB::table("modules as m")
                ->join("group_modules as g", function($join){
                    $join->on("m.group_id", "=", "g.id");
                })
                ->select("g.name as group_module_name", "m.name as module_name")
                ->where("m.id", "=", $module_id)
                ->get();

            return view('emr_death.edit',[
                'hf_info' => $hfInfo,
                'data'=>$data,
                'user'=>$user,
                'province'=>$province,
                'module' => $module
            ]);
        }
    }
    public function create(Request $request)
    {
        $rolde_id = Auth::user()->role_id;
        $module_id = 12;
        $permission = DB::table('module_permissions')->where('role_id', $rolde_id)->where('module_id', $module_id)->first();
        if ($permission->a_create != 1){
            return view('error.error404');
        }
        else{
            $userId = Auth::user()->id;
            $hf_id = User::where('id',$userId)->first(['hf_id'])->hf_id;

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

            $user = User::where('id',$userId)->take(1)->get();
            $province = DB::table("province as p")->select("p.PROCODE","p.PROVINCE","p.PROVINCE_KH")->get();
            if ($user[0]->province_id != 0){
                $province = DB::table("province as p")->where("p.PROCODE",$user[0]->province_id)->select("p.PROCODE","p.PROVINCE","p.PROVINCE_KH")->get();
            }

            $module = DB::table("modules as m")
                ->join("group_modules as g", function($join){
                    $join->on("m.group_id", "=", "g.id");
                })
                ->select("g.name as group_module_name", "m.name as module_name")
                ->where("m.id", "=", $module_id)
                ->get();

            return view('emr_death.create',[
                'hf_info' => $hfInfo,
                'province'=>$province,
                'user'=>$user,
                'module' => $module
            ]);
        }

    }

    public function show($id)
    {
        $rolde_id = Auth::user()->role_id;
        $module_id = 12;
        $permission = DB::table('module_permissions')->where('role_id', $rolde_id)->where('module_id', $module_id)->first();
        if ($permission->a_read != 1){
            return view('error.error404');
        }
        else{
            $hf_id = EMRDeath::where("death_id",$id)->first(['hmis_code'])->hmis_code;

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

            $data = DB::table("emr_death as e")
                ->leftJoin("province as p1", function($join){
                    $join->on("e.deceased_province_code", "=", "p1.procode");
                })
                ->leftJoin("district as dt1", function($join){
                    $join->on("e.deceased_district_code", "=", "dt1.dcode");
                })
                ->leftJoin("commune as c1", function($join){
                    $join->on("e.deceased_commune_code", "=", "c1.ccode");
                })
                ->leftJoin("village as v", function($join){
                    $join->on("e.deceased_village", "=", "v.vcode");
                })
                ->select("e.death_id","e.issue_no","e.deceased_name", "e.death_info", "e.death_type"
                    ,"e.date_of_birth", "e.date_of_death", "e.time_of_death", "e.sex", "e.married_status"
                    ,"medical_file_id", "e.deceased_street","e.age"
                    ,"e.deceased_house", "p1.province_kh as deceased_province_code","dt1.DName_kh as deceased_district_code",
                    "c1.CName_kh as deceased_commune_code", "v.VName_kh as deceased_village")
                ->where("e.death_id", "=", $id)
                ->get();

            $death_info = DB::table('setting_items')
                ->where('setting_items.type_id',2)
                ->select('setting_items.item_id as id', 'setting_items.name_kh as text')
                ->get();

            $death_type = DB::table('setting_items')
                ->where('setting_items.type_id',3)
                ->select('setting_items.item_id as id', 'setting_items.name_kh as text')
                ->get();

            $gender = DB::table('setting_items')
                ->where('setting_items.type_id',1)
                ->select('setting_items.item_id as id', 'setting_items.name_kh as text')
                ->get();

            $married_status = DB::table('setting_items')
                ->where('setting_items.type_id',4)
                ->select('setting_items.item_id as id', 'setting_items.name_kh as text')
                ->get();

            return view('emr_death.print',['data' => $data,'hf_info'=>$hfInfo,'death_info'=>$death_info,
                'death_type'=>$death_type,'sex'=>$gender,'married_status'=>$married_status]);
        }
    }


    public function  getInitPage(){

        $gender = DB::table('setting_items')
            ->where('setting_items.type_id',1)
            ->select('setting_items.item_id as id', 'setting_items.name_kh as text')
            ->get();

        $province = DB::table('province')
            ->select('province.PROCODE as id', 'province.PROVINCE_KH as text')
            ->get();

        $death_info = DB::table('setting_items')
            ->where('setting_items.type_id',2)
            ->select('setting_items.item_id as id', 'setting_items.name_kh as text')
            ->get();

        $death_type = DB::table('setting_items')
            ->where('setting_items.type_id',3)
            ->select('setting_items.item_id as id', 'setting_items.name_kh as text')
            ->get();

        $married_status = DB::table('setting_items')
            ->where('setting_items.type_id',4)
            ->select('setting_items.item_id as id', 'setting_items.name_kh as text')
            ->get();

        $hf_type = DB::table('setting_items')
            ->where('setting_items.type_id',5)
            ->select('setting_items.item_id as id', 'setting_items.name_kh as text')
            ->get();

        return Response()->json(array(
            'gender'=>$gender,
            'province' => $province,
            'married_status'=>$married_status,
            'death_info'=>$death_info,
            'death_type'=>$death_type,
            'hf_type' => $hf_type
        ));
    }

    public function  getDistrict(Request $request){

        $district = DB::table('district')
            ->where('district.PCode',$request->PCode)
            ->select('district.DCode as id', 'district.DName_kh as text')
            ->get();
        return Response()->json(array(
            'district' => $district,

        ));
    }

    public function  getCommune(Request $request){

        $commune = DB::table('commune')
            ->where('commune.DCode',$request->DCode)
            ->select('commune.CCode as id', 'commune.CName_kh as text')
            ->get();
        return Response()->json(array(
            'commune' => $commune,

        ));
    }

    public function  getVillage(Request $request){

        $village = DB::table('village')
            ->where('village.CCode',$request->CCode)
            ->select('village.VCode as id', 'village.VName_kh as text')
            ->get();
        return Response()->json(array(
            'village' => $village,

        ));
    }

    public function Save(Request $request)
    {
        if ($request->death_id == 0){

            $userId = Auth::user()->id;
            $hf_id = User::where('id',$userId)->first(['hf_id'])->hf_id;

            $emr = DB::select( DB::raw("SELECT CONCAT('D',LPAD((SELECT (IFNULL((select max(`death_id`) from emr_death),0)))+1, 10, 0)) as issue_no"));
            $input['death_type'] = $request->death_type;
            $input['hmis_code'] = $request->hmis_code;
            $input['issue_no'] = $emr[0]->issue_no;
            $input['death_info'] = $request->death_info;
            $input['medical_file_id'] = $request->medical_file_id;
            $input['date_of_death'] = $request->date_of_death;
            $input['time_of_death'] = $request->time_of_death;
            $input['deceased_name'] = $request->deceased_name;
            $input['date_of_birth'] = $request->date_of_birth;
            $input['sex'] = $request->sex;
            $input['age'] = $request->age;
            $input['is_baby'] = $request->is_baby;
            $input['married_status'] = $request->married_status;
            $input['deceased_province_code'] = $request->deceased_province_code;
            $input['deceased_district_code'] = $request->deceased_district_code;
            $input['deceased_commune_code'] = $request->deceased_commune_code;
            $input['deceased_village'] = $request->deceased_village;
            $input['deceased_street'] = $request->deceased_street;
            $input['deceased_house'] = $request->deceased_house;
            $input['created_by'] = Auth::user()->id;
            EMRDeath::create($input);
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

//    public function  getData(){
//
//        $data = DB::table("emr_death as d")
//            ->leftJoin("healthfacility as h", function($join){
//                $join->on("d.hmis_code", "=", "h.hfac_code");
//            })
//            ->leftJoin("province as p1", function($join){
//                $join->on("d.deceased_province_code", "=", "p1.procode");
//            })
//            ->leftJoin("district as dt1", function($join){
//                $join->on("d.deceased_district_code", "=", "dt1.dcode");
//            })
//            ->leftJoin("commune as c1", function($join){
//                $join->on("d.deceased_commune_code", "=", "c1.ccode");
//            })
//            ->leftJoin("village as v", function($join){
//                $join->on("d.deceased_village", "=", "v.vcode");
//            })
//            ->leftJoin("setting_items as s1", function($join){
//                $join->on("d.death_info", "=", "s1.item_id")
//                    ->where("s1.type_id", "=", 2);
//            })
//            ->leftJoin("setting_items as s2", function($join){
//                $join->on("d.death_type", "=", "s2.item_id")
//                    ->where("s2.type_id", "=", 3);
//            })
//            ->leftJoin("setting_items as s3", function($join){
//                $join->on("d.sex", "=", "s3.item_id")
//                    ->where("s3.type_id", "=", 1);
//            })
//            ->leftJoin("setting_items as s4", function($join){
//                $join->on("d.married_status", "=", "s4.item_id")
//                    ->where("s4.type_id", "=", 4);
//            })
//            ->select("d.death_id","d.issue_no", "h.hfac_namekh as hfac_label", "s1.name_kh as death_info",
//                "s2.name_kh as death_type", "s3.name_kh as sex", "s4.name_kh as married_status","d.deceased_name",
//                "d.medical_file_id", "d.date_of_death", "d.time_of_death",
//                "p1.province_kh as deceased_province_code","dt1.DName_kh as deceased_district_code",
//                "c1.CName_kh as deceased_commune_code", "v.VName_kh as deceased_village",
//                "d.deceased_street", "d.deceased_house",
//            )
//            ->get();
//        return response()->json($data->toArray());
//
//    }

    public function getData(Request $request){

        $province = $request->province;
        $district = $request->district;
        $hf_code = $request->hf_code;
        $deceased_name = $request->deceased_name;
        $medical_id = $request->medical_id;
        $issue_no = $request->issue_no;
        $results = DB::select("SELECT b.death_id,b.issue_no,b.medical_file_id, b.deceased_name,t3.name_kh as death_type,t2.name_kh as death_info
                ,t1.name_kh as sex,b.date_of_death,b.time_of_death,h.HFAC_NAMEKh,t4.name_kh as married_status,b.age
            FROM emr_death b
            INNER JOIN healthfacility h ON b.hmis_code = h.HFAC_CODE
            INNER JOIN opdistrict od ON h.OD_CODE = od.OD_CODE
            INNER JOIN province p ON od.PRO_CODE = p.PROCODE
            INNER JOIN setting_items t2 ON b.death_info = t2.item_id AND t2.type_id = 2
            INNER JOIN setting_items t3 ON b.death_type = t3.item_id AND t3.type_id = 3
            INNER JOIN setting_items t1 ON b.sex = t1.item_id AND t1.type_id = 1
             INNER JOIN setting_items t4 ON b.married_status = t4.item_id AND t4.type_id = 4
            WHERE b.is_deleted =0
            AND (p.PROCODE = $province OR $province=0)
            AND (od.OD_CODE = $district OR $district=0)
            AND (h.HFAC_CODE = $hf_code OR $hf_code=0)
            AND b.deceased_name LIKE '%$deceased_name%'
            AND b.medical_file_id LIKE '%$medical_id%'
            AND b.issue_no LIKE '%$issue_no%'
            ORDER BY b.issue_no DESC LIMIT 100");

        return response()->json($results);
    }
}
