<?php

namespace App\Http\Controllers;

use App\Models\Question;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\SettingType;
use DB;
use Hash;

class QuestionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $rolde_id = Auth::user()->role_id;
        $module_id = 17;
        $permission = DB::table('module_permissions')->where('role_id', $rolde_id)->where('module_id', $module_id)->first();
        if ($permission->a_read != 1){
            return view('error.error404');
        }
        else{
            $section = DB::select("SELECT s.id,s.description_kh,s.description FROM medical_sections s");
            $answer_type = DB::select("SELECT s.id,s.name FROM answer_types s");
            $setting_type = SettingType::all();
            return view('questions.index',[
                    'setting_type' => $setting_type,
                    'section'=>$section,
                    'answer_type'=>$answer_type,
                    'permission'=>$permission
                ]
            );
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

    public function Save(Request $request)
    {
        if ($request->id == 0){
            $input = $request->all();
            Question::create($input);
        }
        else{
            $input = $request->all();
            $data = Question::find($request->id);
            $data->update($input);
        }
        return Response()->json(array(
            'code' => 0,
        ));
    }

    public function  getData(Request $request){

        $data = DB::select("SELECT q.id, q.section_id,s.description_kh as section_name, IFNULL(q.question,'') as question
                        ,IFNULL(q.question_kh,'') as question_kh,q.answer_type,a.name as answer_type_name
                        ,q.setting_type_id,s1.name_kh setting_type_name,q.order_no
                        FROM medical_questions q
                        INNER JOIN medical_sections s ON q.section_id = s.id
                        INNER JOIN answer_types a ON q.answer_type = a.id
                        LEFT JOIN setting_types s1 ON q.setting_type_id = s1.id
                        WHERE q.section_id = $request->section_id
                        ORDER BY q.section_id,q.order_no");
        return response()->json($data);

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
     * @param  \App\Models\Question  $question
     * @return \Illuminate\Http\Response
     */
    public function show(Question $question)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Question  $question
     * @return \Illuminate\Http\Response
     */
    public function edit(Question $question)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Question  $question
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Question $question)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Question  $question
     * @return \Illuminate\Http\Response
     */
    public function destroy(Question $question)
    {
        //
    }
}
