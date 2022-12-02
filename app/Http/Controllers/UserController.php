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
//    function __construct()
//    {
//        $this->middleware('permission:product-list|product-create|product-edit|product-delete', ['only' => ['index','show']]);
//        $this->middleware('permission:product-create', ['only' => ['create','store']]);
//        $this->middleware('permission:product-edit', ['only' => ['edit','update']]);
//        $this->middleware('permission:product-delete', ['only' => ['destroy']]);
//    }
    public function index(Request $request)
    {
        $rolde_id = Auth::user()->role_id;
        $module_id = 2;
        $permission = DB::table('module_permissions')->where('role_id', $rolde_id)->where('module_id', $module_id)->first();
        if ($permission->a_read != 1){
            return view('error.error404');
        }
        else{
            return view('users.index');
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
//    public function update(Request $request, $id)
//    {
//        $this->validate($request, [
//            'name' => 'required',
//            'email' => 'required|email|unique:users,email,'.$id,
//            'password' => 'same:confirm-password',
//            'roles' => 'required'
//        ]);
//
//        $input = $request->all();
//        if(!empty($input['password'])){
//            $input['password'] = Hash::make($input['password']);
//        }else{
//            $input = Arr::except($input,array('password'));
//        }
//
//        $user = User::find($id);
//        $user->update($input);
//        DB::table('model_has_roles')->where('model_id',$id)->delete();
//
//        $user->assignRole($request->input('roles'));
//
//        return redirect()->route('users.index')
//            ->with('success','User updated successfully');
//    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        User::find($id)->delete();
        return redirect()->route('users.index')
            ->with('success','User deleted successfully');
    }

    public function  getData(){

        $data = DB::table('users')
            ->join('roles', 'users.role_id', '=', 'roles.id')
            ->select('users.*', 'roles.name as role_name')
            ->get();
        return response()->json($data->toArray());

    }

    public function  getInitPage(){
        $roleList = DB::table('roles')
            ->select('roles.id as id', 'roles.name as text')
            ->get();

        return Response()->json(array(
            'role' => $roleList,
        ));
//        return response()->json($data->toArray());
    }
}
