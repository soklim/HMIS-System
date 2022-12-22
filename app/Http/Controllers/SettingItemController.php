<?php

namespace App\Http\Controllers;

use App\Models\SettingType;
use App\Models\SettingItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use DB;
use Hash;

class SettingItemController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $rolde_id = Auth::user()->role_id;
        $module_id = 6;
        $permission = DB::table('module_permissions')->where('role_id', $rolde_id)->where('module_id', $module_id)->first();
        if ($permission->a_read != 1){
            return view('error.error404');
        }
        else{
            $setting_type = SettingType::all();
            return view('setting_items.index',['setting_type' => $setting_type]);
        }
    }

    public function Save(Request $request)
    {
        if ($request->id == 0){
            $input['name'] = $request->name;
            $input['name_kh'] = $request->name;
            $input['type_id'] = $request->type_id;
            $input['item_id'] = $request->item_id;
            $input['active'] = 1;
            SettingItem::create($input);
        }
        else{
            $input = $request->all();
            $data = SettingItem::find($request->id);
            $data->update($input);
        }
        return Response()->json(array(
            'code' => 0,
        ));
    }
    public function  getData(){

        $data = DB::table('setting_items as m')
            ->join('setting_types as g', 'm.type_id', '=', 'g.id')
            ->select('m.*', 'g.name_kh as type_name')
            ->orderByRaw('m.type_id,m.item_id ASC')
            ->get();
        return response()->json($data->toArray());

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
     * @param  \App\Models\SettingItem  $settingItem
     * @return \Illuminate\Http\Response
     */
    public function show(SettingItem $settingItem)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\SettingItem  $settingItem
     * @return \Illuminate\Http\Response
     */
    public function edit(SettingItem $settingItem)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\SettingItem  $settingItem
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, SettingItem $settingItem)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\SettingItem  $settingItem
     * @return \Illuminate\Http\Response
     */
    public function destroy(SettingItem $settingItem)
    {
        //
    }
}
