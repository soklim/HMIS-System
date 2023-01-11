<?php

namespace App\Http\Controllers;

use App\Models\MCCD;
use App\Models\MCCD_Section_A;
use App\Models\MCCD_Section_B;
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
    public function index($type_id)
    {
        $rolde_id = Auth::user()->role_id;
        if($type_id == 1){
            $module_id = 15;
        }
        else{
            $module_id = 16;
        }

        $permission = DB::table('module_permissions')->where('role_id', $rolde_id)->where('module_id', $module_id)->first();
        $per_coder = DB::table('module_permissions')->where('role_id', $rolde_id)->where('module_id', 18)->get();
        if(empty($per_coder)){
            $per_coder= DB::table("module_permissions as p")
                            ->select("p.id", DB::raw("18 as module_id") , DB::raw("0 as a_create")
                                , DB::raw("0 as a_read"), DB::raw("0 as a_update"), DB::raw("0 as a_delete"))
                            ->where("p.id", "=", 1)->get();
        }
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

            return view('mccd.index',[
                'user'=>$user,
                'province'=>$province,
                'permission'=>$permission,
                'per_coder'=>$per_coder,
                'module' => $module,
                'type_id'=>$type_id
            ]);
        }

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create_new($type_id, $id)
    {
        $rolde_id = Auth::user()->role_id;
        if($type_id == 1){
            $module_id = 15;
        }
        else{
            $module_id = 16;
        }
        $permission = DB::table('module_permissions')->where('role_id', $rolde_id)->where('module_id', $module_id)->first();
        if ($permission->a_create != 1){
            return view('error.error404');
        }
        else{

            $data = DB::select("SELECT 2 AS level_id,q.id AS question_id,q.section_id,ifnull(q.question,'') description,ifnull(q.question_kh,'') AS description_kh
                                ,q.answer_type,q.setting_type_id,q.order_no,CASE WHEN q.id IN (3,6,10,12,22) THEN 1 ELSE 0 END required
                                FROM medical_questions as q
                                ORDER by q.order_no");

            $module = DB::table("modules as m")
                ->join("group_modules as g", function($join){
                    $join->on("m.group_id", "=", "g.id");
                })
                ->select("g.name as group_module_name", "m.name as module_name")
                ->where("m.id", "=", $module_id)
                ->get();

            $death = DB::table("emr_death as d")
                ->join("setting_items as s1", function($join){
                    $join->on("d.sex", "=", "s1.item_id")
                        ->where("s1.type_id", "=", 1);
                })
                ->join("setting_items as s2", function($join){
                    $join->on("d.death_info", "=", "s2.item_id")
                        ->where("s2.type_id", "=", 2);
                })
                ->join("setting_items as s3", function($join){
                    $join->on("d.death_type", "=", "s3.item_id")
                        ->where("s3.type_id", "=", 3);
                })
                ->select("d.death_id", "d.issue_no", "d.deceased_name", "s2.name_kh as death_info", "s3.name_kh as death_type"
                        ,"d.age","s1.name_kh as sex")
                ->where("d.death_id", "=", $id)
                ->get();

            $coder = DB::table("coders")
                ->select("id", "name_kh")
                ->get();
            return view('mccd.create',[
                'permission'=>$permission,
                'data'=>$data,
                'death'=>$death,
                'module'=>$module,
                'coders'=>$coder,
                'type_id'=>$type_id
            ]);
        }
    }

    public function getData(Request $request){

        $type_id = $request->type_id;
        $province = $request->province;
        $district = $request->district;
        $hf_code = $request->hf_code;
        $deceased_name = $request->deceased_name;
        $medical_id = $request->medical_id;
        $issue_no = $request->issue_no;
        $results = DB::select("SELECT b.death_id
                                ,IFNULL(m.mccd_id,0) as mccd_id
                                ,IFNULL(m.issue_no,'') as issue_no
                                ,IFNULL(m.status_id,0) as status_id
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
                                LEFT JOIN mccd m ON m.death_id = b.death_id AND m.type_id = $type_id
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
    public function Save(Request $request)
    {
        try{
            $section_a = $request->json()->all()["mccd_section_a"];
            $section_b = $request->json()->all()["mccd_section_b"];
            if($request->json()->all()["mccd_id"] == 0){
                if($request->json()->all()["type_id"] == 1){
                    $issue_no = DB::select(DB::raw("SELECT CONCAT('M',LPAD((SELECT (IFNULL((select max(`mccd_id`) from mccd),0)))+1, 10, 0)) as issue_no"));
                }
                else{
                    $issue_no = DB::select(DB::raw("SELECT CONCAT('F',LPAD((SELECT (IFNULL((select max(`mccd_id`) from mccd),0)))+1, 10, 0)) as issue_no"));
                }

                $mccd['death_id'] = $request->json()->all()["death_id"];
                $mccd['issue_no'] = $issue_no[0]->issue_no;
                $mccd['status_id'] = $request->json()->all()["status_id"];
                $mccd['type_id'] = $request->json()->all()["type_id"];
                $mccd['created_by'] = Auth::user()->id;
                MCCD::create($mccd);
                $insertedId = DB::table('mccd')->max('mccd_id');

            }
            else{
                $mccd['updated_by'] = Auth::user()->id;
                $data = MCCD::where('mccd_id',$request->json()->all()["mccd_id"]);
                $data->update($mccd);
            }

            //section A
            foreach($section_a as $item) { //foreach element in $arr

                if($item['id'] == 0){
                    $section_a['mccd_id'] = $insertedId;
                    $section_a['order_no'] = $item["order_no"];
                    $section_a['death_reason'] = $item["death_reason"];
                    $section_a['period'] = $item["period"];
                    $section_a['level_coder'] = $item["level_coder"];
                    $section_a['created_by'] = Auth::user()->id;
                    MCCD_Section_A::create($section_a);
                }
                else{

                    $item['updated_by'] = Auth::user()->id;
                    $data = MCCD_Section_A::where('id',$item['id']);
                    $data->update($item);
                }
            }

            //section B
            foreach($section_b as $item) { //foreach element in $arr
                if($item['id'] == 0){
                    $section_b['mccd_id'] = $insertedId;
                    $section_b['question_id'] = $item["question_id"];
                    $question = DB::table("medical_questions as m")
                        ->select("m.question", "m.question_kh", "m.answer_type", "m.setting_type_id", "m.order_no")
                        ->where("m.id", "=", $item["question_id"])
                        ->limit(1)->get();
                    $section_b['question_name'] = $question[0]->question;
                    $section_b['question_name_kh'] = $question[0]->question_kh;
                    $section_b['answer_type_id'] = $question[0]->answer_type;
                    $section_b['setting_type_id'] = $question[0]->setting_type_id;
                    $section_b['order_no'] = $question[0]->order_no;
                    $section_b['answer'] = $item["answer"];
                    $section_b['created_by'] = Auth::user()->id;
                    MCCD_Section_B::create($section_b);
                }
                else{

                    $id = $item["id"];
                    $ans = $item["answer"];
                    $userId = Auth::user()->id;
                    $results = DB::select("UPDATE mccd_section_b set answer='$ans',updated_at=CURRENT_TIMESTAMP(),updated_by=$userId where id=$id");
                }
            }

            return Response()->json(array(
                'code' => 0,
                'id'=>$section_b
            ));
        }
        catch (Exception $e){
            return Response()->json(array(
                'code' => 1,
                "msg"=>$e->getMessage(),
            ));
        }

    }

    public function SaveCoder(Request $request)
    {
        try{
            $section_a = $request->json()->all()["mccd_section_a"];
            if($request->json()->all()["mccd_id"] != 0){
                $mccd['updated_by'] = Auth::user()->id;
                $mccd['status_id'] = $request->json()->all()["status_id"];
                $data = MCCD::where('mccd_id',$request->json()->all()["mccd_id"]);
                $data->update($mccd);
            }


            //section A
            foreach($section_a as $item) { //foreach element in $arr
                $item['updated_by'] = Auth::user()->id;
                $data = MCCD_Section_A::where('id',$item['id']);
                $data->update($item);
            }

            return Response()->json(array(
                'code' => 0,
            ));
        }
        catch (Exception $e){
            return Response()->json(array(
                'code' => 1,
                "msg"=>$e->getMessage(),
            ));
        }

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
    public function edits($type_id,$id)
    {
        if($type_id == 1){
            $module_id = 15;
        }
        else{
            $module_id = 16;
        }
        $rolde_id = Auth::user()->role_id;
        $permission = DB::table('module_permissions')->where('role_id', $rolde_id)->where('module_id', $module_id)->first();
        if ($permission->a_update != 1){
            return view('error.error404');
        }
        else{

            $section_b = DB::select("SELECT m.id, 2 AS level_id,q.id AS question_id,q.section_id,ifnull(q.question,'') description,ifnull(q.question_kh,'') AS description_kh
                                ,q.answer_type,q.setting_type_id,q.order_no,CASE WHEN q.id IN (3,6,10,12,22) THEN 1 ELSE 0 END required,m.answer
                                FROM medical_questions as q
                                INNER JOIN mccd_section_b m ON q.id = m.question_id
                                WHERE m.mccd_id = $id
                                ORDER by q.order_no");

            $section_a = DB::select("SELECT m.id, m.order_no,m.death_reason,m.period,m.level_coder FROM mccd_section_a m WHERE m.mccd_id=$id ORDER BY m.order_no");
            $module = DB::table("modules as m")
                ->join("group_modules as g", function($join){
                    $join->on("m.group_id", "=", "g.id");
                })
                ->select("g.name as group_module_name", "m.name as module_name")
                ->where("m.id", "=", $module_id)
                ->get();

            $mccd = DB::table("mccd")
                ->where("mccd_id", "=", $id)
                ->get();
            $death_id = MCCD::where("mccd_id",$id)->first(['death_id'])->death_id;

            $death = DB::table("emr_death as d")
                ->join("setting_items as s1", function($join){
                    $join->on("d.sex", "=", "s1.item_id")
                        ->where("s1.type_id", "=", 1);
                })
                ->join("setting_items as s2", function($join){
                    $join->on("d.death_info", "=", "s2.item_id")
                        ->where("s2.type_id", "=", 2);
                })
                ->join("setting_items as s3", function($join){
                    $join->on("d.death_type", "=", "s3.item_id")
                        ->where("s3.type_id", "=", 3);
                })
                ->select("d.death_id", "d.issue_no", "d.deceased_name", "s2.name_kh as death_info", "s3.name_kh as death_type"
                    ,"d.age","s1.name_kh as sex")
                ->where("d.death_id", "=", $death_id)
                ->get();

            $coder = DB::table("coders")
                ->select("id", "name_kh")
                ->get();

            return view('mccd.edit',[
                'permission'=>$permission,
                'section_a'=>$section_a,
                'section_b'=>$section_b,
                'death'=>$death,
                'module'=>$module,
                'coders'=>$coder,
                'mccd'=>$mccd,
                'type_id'=>$type_id
            ]);
        }
    }

    public function addCoder($type_id,$mccd_id)
    {
        $module_id = 18;
        $rolde_id = Auth::user()->role_id;
        $permission = DB::table('module_permissions')->where('role_id', $rolde_id)->where('module_id', $module_id)->first();
        if ($permission->a_update != 1){
            return view('error.error404');
        }
        else{

            $section_a = DB::select("SELECT m.id, m.order_no,m.death_reason,m.period,m.level_coder FROM mccd_section_a m WHERE m.mccd_id=$mccd_id ORDER BY m.order_no");
            $module = DB::table("modules as m")
                ->join("group_modules as g", function($join){
                    $join->on("m.group_id", "=", "g.id");
                })
                ->select("g.name as group_module_name", "m.name as module_name")
                ->where("m.id", "=", $module_id)
                ->get();

            $mccd = DB::table("mccd")
                ->where("mccd_id", "=", $mccd_id)
                ->get();
            $death_id = MCCD::where("mccd_id",$mccd_id)->first(['death_id'])->death_id;

            $death = DB::table("emr_death as d")
                ->join("setting_items as s1", function($join){
                    $join->on("d.sex", "=", "s1.item_id")
                        ->where("s1.type_id", "=", 1);
                })
                ->join("setting_items as s2", function($join){
                    $join->on("d.death_info", "=", "s2.item_id")
                        ->where("s2.type_id", "=", 2);
                })
                ->join("setting_items as s3", function($join){
                    $join->on("d.death_type", "=", "s3.item_id")
                        ->where("s3.type_id", "=", 3);
                })
                ->select("d.death_id", "d.issue_no", "d.deceased_name", "s2.name_kh as death_info", "s3.name_kh as death_type"
                    ,"d.age","s1.name_kh as sex")
                ->where("d.death_id", "=", $death_id)
                ->get();

            $coder = DB::table("coders")
                ->select("id", "name_kh")
                ->get();

            return view('mccd.coder',[
                'permission'=>$permission,
                'section_a'=>$section_a,
                'death'=>$death,
                'module'=>$module,
                'coder'=>$coder,
                'mccd'=>$mccd,
                'type_id'=>$type_id
            ]);
        }
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
