<?php

namespace App\Http\Controllers;

use App\Models\SettingType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use DB;
use Hash;
class SettingTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $rolde_id = Auth::user()->role_id;
        $module_id = 5;
        $permission = DB::table('module_permissions')->where('role_id', $rolde_id)->where('module_id', $module_id)->first();
        if ($permission->a_read != 1){
            return view('error.error404');
        }
        else{
            return view('setting_types.index');
        }
    }

    public function Save(Request $request)
    {
        if ($request->id == 0){
            $input['name'] = $request->name;
            $input['name_kh'] = $request->name_kh;
            $input['description'] = $request->description;
            SettingType::create($input);
        }
        else{
            $input = $request->all();
            $data = SettingType::find($request->id);
            $data->update($input);
        }
        return Response()->json(array(
            'code' => 0,
        ));
    }
    public function  getData(){

        $data = DB::table('setting_types')
            ->select('setting_types.*')
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
     * @param  \App\Models\SettingType  $settingType
     * @return \Illuminate\Http\Response
     */
    public function show(SettingType $settingType)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\SettingType  $settingType
     * @return \Illuminate\Http\Response
     */
    public function edit(SettingType $settingType)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\SettingType  $settingType
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, SettingType $settingType)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\SettingType  $settingType
     * @return \Illuminate\Http\Response
     */
    public function destroy(SettingType $settingType)
    {
        //
    }
}
