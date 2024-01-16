<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;
use Session;
use Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    //ngăn chặn biết đường dân
    public function __construct()
    {
        $this->middleware('permission:publish user|edit user|add user|delete user',['only'=>['index','show']]);
        $this->middleware('permission:add user',['only'=>['create','store']]);
        $this->middleware('permission:edit user',['only'=>['edit','update']]);
        $this->middleware('permission:delete user',['only'=>['destroy']]);
    }

    public function index()
    {
        //them vao bang Role bang name
        // Role::create(['name'=>'publisher']);
         //them vao bang Permission bang name 
        // Permission::create(['name'=>'add leech episode']);
        //de gan vai tro role co quyen permission
        // $role = Role::find(1);
        // $permission = Permission::find(31);
        //vai tro co nhung quyen gi
        // $role->givePermissionTo($permission);
        //quyen duoc trao vai tro gi
        //syncRoles de len quyen da co con permission them tiep
        // $permission->assignRole($role);
        // vai tro xoa quyen 
        // $role->revokePermissionTo($permission);
        // quyen khong trai cho vai tro role
        // $permission->removeRole($role);
        //assignRole them quyen
        //removeRole xoa quyen
         // auth()->user()->assignRole('Admin');
        // auth()->user()->givePermissionTo('edit user','delete user');
        // $user = User::find(5);
        // $user->assignRole('writer');
        $user = User::with('roles','permissions')->orderBy('id','DESC')->get();

        // dd($user)
        return view('admin.user.index',compact('user'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.user.form');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->all();
        $user = new User();
        $user->password = Hash::make($data['password']);
        $user->email = $data['email'];
        $user->name = $data['name'];
        $user->save();
        toastr()->success('Thành Công','Thêm User Thành Công');
        return redirect()->route('user.index')->with('status','Thêm User Thành Công');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = User::find($id);
        return view('admin.user.form',compact('user'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $data = $request->all();
        $user = User::find($id);

        // Kiểm tra xem mật khẩu hiện tại nhập vào có khớp với mật khẩu trong database không
        if(Hash::check($data['password'], $user->password)){
            if($data['newpassword'] === $data['confirm']){
                $user->password = Hash::make($data['newpassword']);
            }
            else{
                toastr()->error('Thất Bại','Cập Nhật User Thất Bại ');
                return redirect()->back()->with('errors','Cập Nhật User Thất Bại! Mã Xác Nhận Confirm Password Không Đúng');
            }
        }
        else{
            toastr()->error('Thất Bại','Cập Nhật User Thật Bại');
            return redirect()->back()->with('errors','Cập Nhật User Thất Bại! Old password Không Chính Xác ');
        }
        $user->email = $data['email'];
        $user->name = $data['name'];
        $user->save();
        toastr()->success('Thành Công','Cập Nhật User Thành Công');
        return redirect()->route('user.index')->with('status','Cập Nhật User Thành Công');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        User::find($id)->delete();
        toastr()->success('Thành Công','Xóa User Thành Công');
        return redirect()->route('user.index')->with('status','Delete Thành Công');
    }
    public function phan_vai_tro($id){
        $user = User::find($id);
        $name_roles = $user->roles->all();
        $all_column_roles = $user->roles->first();
        $permission = Permission::orderBy('id','ASC')->get();
        $role = Role::orderBy('id','DESC')->get();
        
        return view('admin.user.phanvaitro',compact('user','role','all_column_roles','name_roles','permission'));
    }
    public function insert_roles(Request $request, $id){
        $data = $request->all();
        $user = User::find($id);
        $user->syncRoles($data['role']);
        $role_id = $user->roles->first()->id;
        toastr()->success('Thành Công','Thêm Vai Trò Cho User Thành Công');
        return redirect()->back();
    }

    public function phan_quyen($id){
        $user = User::find($id);
        $name_roles = $user->roles->all();
        $all_column_roles = $user->roles->first();
        $permission = Permission::orderBy('id','ASC')->get();
        
        //lấy quyền
        $get_permission_viarole= $user->getPermissionsViaRoles();
        return view('admin.user.phanquyen',compact('user','all_column_roles','name_roles','permission','get_permission_viarole'));
    }

    public function insert_permission(Request $request, $id)
    {
        $data = $request->all();
        $user = User::find($id);
        
        $role_id = $user->roles->first()->id;
        //them quyền
        $role = Role::find($role_id);
        $role->syncPermissions($data['permission']);

        toastr()->success('Thành Công','Thêm Quyền Cho User Thành Công');
        return redirect()->back();
    }

    public function insert_per(Request $request){
        $data = $request->all();
        $permission = new Permission();
        $permission->name = $data['permission'];
        $permission->save();
        toastr()->success('Thành Công','Thêm Quyền Thành Công');
        return redirect()->back();

    }
    public function impersonate($id){
        $user = User::find($id);
        if($user){
            Session::put('impersonate',$user->id);
        }
        return redirect('/home');
    }
    
}
