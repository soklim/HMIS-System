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

            $userId = Auth::user()->id;
            return view('mccd.index',[
                'user'=>$user,
                'province'=>$province,
                'permission'=>$permission,
                'module' => $module
            ]);
        }

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create_new($id)
    {
        $rolde_id = Auth::user()->role_id;
        $module_id = 15;
        $permission = DB::table('module_permissions')->where('role_id', $rolde_id)->where('module_id', $module_id)->first();
        if ($permission->a_read != 1){
            return view('error.error404');
        }
        else{

            $userId = Auth::user()->id;
//            $data = DB::select("CALL SP_MCCD_MEDICAL('')");
            $data = DB::select("SELECT * FROM vw_mccd_medical");
            $death = DB::table("emr_death as d")

                ->select("d.issue_no","d.death_id","d.deceased_name")
                ->where("d.is_deleted",0)
                ->get();

            $module = DB::table("modules as m")
                ->join("group_modules as g", function($join){
                    $join->on("m.group_id", "=", "g.id");
                })
                ->select("g.name as group_module_name", "m.name as module_name")
                ->where("m.id", "=", $module_id)
                ->get();

            $death = DB::table("emr_death as d")
                ->join("setting_items as s2", function($join){
                    $join->on("d.death_info", "=", "s2.item_id")
                        ->where("s2.type_id", "=", 2);
                })
                ->join("setting_items as s3", function($join){
                    $join->on("d.death_type", "=", "s3.item_id")
                        ->where("s3.type_id", "=", 3);
                })
                ->select("d.death_id", "d.issue_no", "d.deceased_name", "s2.name_kh as death_info", "s3.name_kh as death_type")
                ->where("d.death_id", "=", $id)
                ->get();

            $coder = DB::table("coder")
                ->select("id", "name_kh")
                ->get();
            return view('mccd.create',[
                'permission'=>$permission,
                'data'=>$data,
                'death'=>$death,
                'module'=>$module,
                'coder'=>$coder
            ]);
        }
    }

    public function getData(Request $request){

        $province = $request->province;
        $district = $request->district;
        $hf_code = $request->hf_code;
        $deceased_name = $request->deceased_name;
        $medical_id = $request->medical_id;
        $issue_no = $request->issue_no;
        $results = DB::select("SELECT b.death_id
                                ,IFNULL(m.mccd_id,0) as mccd_id
                                ,IFNULL(m.issue_no,'') as issue_no
                                ,b.medical_file_id, b.deceased_name,t3.name_kh as death_type,t2.name_kh as death_info
                                ,t1.name_kh as sex,b.date_of_death,b.time_of_death,h.HFAC_NAMEKh,t4.name_kh as married_status,b.age,t15.name_kh as age_type_name
                                FROM emr_death b
                                INNER JOIN healthfacility h ON b.hmis_code = h.HFAC_CODE
                                INNER JOIN opdistrict od ON h.OD_CODE = od.OD_CODE
                                INNER JOIN province p ON od.PRO_CODE = p.PROCODE
                                INNER JOIN setting_items t2 ON b.death_info = t2.item_id AND t2.type_id = 2
                                INNER JOIN setting_items t3 ON b.death_type = t3.item_id AND t3.type_id = 3
                                INNER JOIN setting_items t1 ON b.sex = t1.item_id AND t1.type_id = 1
                                INNER JOIN setting_items t4 ON b.married_status = t4.item_id AND t4.type_id = 4
                                INNER JOIN setting_items t15 ON b.age_type_id = t15.item_id AND t15.type_id = 15
                                LEFT JOIN mccd m ON m.death_id = b.death_id
                                WHERE b.is_deleted =0
                                AND (p.PROCODE = $province OR $province=0)
                                AND (od.OD_CODE = $district OR $district=0)
                                AND (h.HFAC_CODE = $hf_code OR $hf_code=0)
                                AND b.deceased_name LIKE '%$deceased_name%'
                                AND b.medical_file_id LIKE '%$medical_id%'
                                AND IFNULL(m.issue_no,'') LIKE '%$issue_no%'
                                ORDER BY m.issue_no DESC LIMIT 100");

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
