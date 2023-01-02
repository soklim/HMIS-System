<?php

namespace App\Http\Controllers;

use App\Models\ModulePermission;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Role;
use DB;
use Hash;
use Illuminate\Support\Arr;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index(Request $request)
    {

        $rolde_id = Auth::user()->role_id;
        $module_id = 2;
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

            return view('users.index',[
                'module' => $module
            ]);
        }

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function Save(Request $request)
    {
        if ($request->id == 0){
            $input['name'] = $request->name;
            $input['email'] = $request->email;
            $input['role_id'] = $request->role_id;
            $input['sex'] = $request->sex;
            $input['phone'] = $request->phone;
            $input['province_id'] = $request->province_id;
            $input['district_id'] = $request->district_id;
            $input['hf_id'] = $request->hf_id;
            $input['password'] = Hash::make('123123');
            User::create($input);
        }
        else{
            $input = $request->all();
            $input = Arr::except($input,array('password'));

            $user = User::find($request->id);
            $user->update($input);
        }
        return Response()->json(array(
            'code' => 0,
        ));
    }

    public function Update(Request $request)
    {

        $user = User::find($request->id);

        if($user) {
            $user->active = $request->active;
            $user->save();
        }
        return Response()->json(array(
            'code' => 0,
        ));
    }
    public function ResetPassword(Request $request)
    {

        $user = User::find($request->id);
        $default_password="123";
        if($user) {
            $user->password = Hash::make($request->password);
            $user->save();
        }
        return Response()->json(array(
            'code' => 0,
        ));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function  getData(){

        $data = DB::table('users')
            ->join('roles', 'users.role_id', '=', 'roles.id')
            ->join('setting_items as s1', 'users.sex', '=', 's1.item_id')
            ->where('s1.type_id',1)
            ->select('users.*', 'roles.name as role_name','s1.name_kh as sex_name')
            ->get();
        return response()->json($data->toArray());

    }

    public function  getDistrict(Request $request ){

        $od = DB::table('opdistrict')
            ->where('opdistrict.PRO_CODE',$request->pro_code)
            ->select('opdistrict.OD_CODE as id', 'opdistrict.OD_NAME_KH as text')
            ->get();
        return Response()->json(array(
            'district' => $od,

        ));
    }

    public function  getHF(Request $request ){

        $hf = DB::table('healthfacility')
            ->where('healthfacility.OD_CODE',$request->district_code)
            ->select('healthfacility.HFAC_CODE as id',DB::raw("CONCAT(healthfacility.HFAC_Label,'-',healthfacility.HFAC_NAMEKh) AS text"))
            ->get();
        return Response()->json(array(
            'HF' => $hf,

        ));
    }

    public function  getInitPage(){
        $roleList = DB::table('roles')
            ->select('roles.id as id', 'roles.name as text')
            ->orderBy('roles.id')
            ->get();

        $gender = DB::table('setting_items')
            ->where('setting_items.type_id',1)
            ->select('setting_items.item_id as id', 'setting_items.name_kh as text')
            ->get();

        $province = DB::table('province')
            ->select('province.PROCODE as id', 'province.PROVINCE_KH as text')
            ->get();

        $email = DB::table('users')
            ->select('users.email')
            ->get();


        return Response()->json(array(
            'role' => $roleList,
            'gender'=>$gender,
            'province' => $province,
            'email' => $email,

        ));
    }

}
