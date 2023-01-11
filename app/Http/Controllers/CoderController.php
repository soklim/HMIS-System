<?php

namespace App\Http\Controllers;

use App\Models\Coder;
use Illuminate\Http\Request;
use DB;
use Hash;
use Illuminate\Support\Facades\Auth;

class CoderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $rolde_id = Auth::user()->role_id;
        $module_id = 18;
        $permission = DB::table('module_permissions')->where('role_id', $rolde_id)->where('module_id', $module_id)->first();
        if ($permission->a_read != 1){
            return view('error.error404');
        }
        else{
            $module = DB::table("modules as m")
                ->join("group_modules as g", function($join){
                    $join->on("m.group_id", "=", "g.id");
                })
                ->select("g.name as group_module_name", "m.name as module_name")
                ->where("m.id", "=", $module_id)
                ->get();
            return view('coders.index',[
                'module' => $module
            ]);
        }
    }

    public function Save(Request $request)
    {
        if ($request->id == 0){
            $input['name'] = $request->name;
            $input['name_kh'] = $request->name_kh;
            $input['description'] = $request->description;
            $data = Coder::create($input);
        }
        else{
            $input = $request->all();
            $data = Coder::find($request->id);
            $data->update($input);
        }
        return Response()->json(array(
            'code' => 0,
            'data' =>$data
        ));
    }
    public function  getData(){

        $data = DB::table('coders')
            ->select('coders.*')
            ->get();
        return response()->json($data->toArray());

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
     * @param  \App\Models\Coder  $coder
     * @return \Illuminate\Http\Response
     */
    public function show(Coder $coder)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Coder  $coder
     * @return \Illuminate\Http\Response
     */
    public function edit(Coder $coder)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Coder  $coder
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Coder $coder)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Coder  $coder
     * @return \Illuminate\Http\Response
     */
    public function destroy(Coder $coder)
    {
        //
    }
}
