<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Info;

class InfoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    //ngăn chặn biết đường dân
    public function __construct()
    {
        $this->middleware('permission:publish information|edit information|add information|delete information',['only'=>['index','show']]);
        $this->middleware('permission:add information',['only'=>['create','store']]);
        $this->middleware('permission:edit information',['only'=>['edit','update']]);
        $this->middleware('permission:delete information',['only'=>['destroy']]);
    }
    
    public function index()
    {
        $list = Info::orderBy('position','ASC')->get();
        return view('admin.info.index',compact('list'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.info.form');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|unique:info|max:255',
           
            'logo' => 'required|image|mimes:jpg,png,jpeg,gif,svg|max:2048|dimensions:min_width=100,min_height=100,max_width=2000,max_height=2000',
            'description' => 'required|max:255',
            'position' => 'required',
            'copyright' => 'required',
            
        ],
        [
            'title.unique' => 'Tiêu Đề Website này đã có, vui lòng điền tên khác',
            'title.required' => 'Tiêu Đề Website Phải Có',
            'logo.required' => 'Hình Ảnh Lgo Phải Có',
            'copyright.required' => 'copyright Phải Có',
            'position.required' => 'Thứ Tự Thông Tin Phải Có',
            'description.required' => 'Mô Tả Thông Tin Website Phải Có',
            
            
            
        ]);
        $info = new Info();
        $info->title = $data['title'];
        $info->copyright = $data['copyright'];
        $info->position = $data['position'];
        $info->description = $data['description'];
        $get_image = $request->logo;
        if($get_image){
        $path = 'uploads/logo/';
        $get_name_image = $get_image->getClientOriginalName();
        $name_image = current(explode('.',$get_name_image));
        $new_image = $name_image.rand(0,99).'.'.$get_image->getClientOriginalExtension();
        $get_image->move($path,$new_image);
        $info->logo = $new_image;
        }
        $info->save();
        toastr()->success('Thành Công','Thêm Thông Tin Thành Công');
        return redirect()->route('info.index')->with('status','Thêm Thông Tin Thành Công');
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
        $infor = Info::find($id);
        return view('admin.info.form',compact('infor'));
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
        $data = $request->validate([
            'title' => 'required|unique:info|max:255',
           
            'logo' => 'required|image|mimes:jpg,png,jpeg,gif,svg|max:3070|dimensions:min_width=100,min_height=100,max_width=2000,max_height=2000',
            'description' => 'required|max:255',
            'position' => 'required',
            'copyright' => 'required',
            
        ],
        [
            'title.unique' => 'Tiêu Đề Website này đã có, vui lòng điền tên khác',
            'title.required' => 'Tiêu Đề Website Phải Có',
            'logo.required' => 'Hình Ảnh Lgo Phải Có',
            'position.required' => 'Thứ Tự Thông Tin Phải Có',
            'description.required' => 'Mô Tả Thông Tin Website Phải Có',
            'copyright.required' => 'copyright Phải Có',
            
            
        ]);
        $info = Info::find($id);
        $info->title = $data['title'];
        $info->copyright = $data['copyright'];
        $info->position = $data['position'];
        $info->description = $data['description'];
        $get_image = $request->logo;
        if($get_image){
            // detele image
            $path_unlink = 'uploads/logo/'.$info->logo;
            if(file_exists($path_unlink)){
                unlink($path_unlink);
            }
            // add image new
            $path = 'uploads/logo/';
            $get_name_image = $get_image->getClientOriginalName();
            $name_image = current(explode('.',$get_name_image));
            $new_image = $name_image.rand(0,99).'.'.$get_image->getClientOriginalExtension();
            $get_image->move($path,$new_image);
            $info->logo = $new_image;
        }
        $info->save();
        toastr()->success('Thành Công','Cập Nhật Thông Tin Website Thành Công');
        return redirect()->route('info.index')->with('status','Cập Nhật Thông Tin Website Thành Công');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $info = Info::find($id);
        $path_unlink = 'uploads/logo/'.$info->logo;
            if(file_exists($path_unlink)){
                unlink($path_unlink);
            }
        $info->delete();
        toastr()->success('Thành Công','Xóa Phim Thành Công');
          return redirect()->route('info.index')->with('status','Xóa Thành Công');
    }
    public function resorting_info(Request $request){
        $data = $request->all();
        foreach($data['array_id'] as $key => $value){
            $info = Info::find($value);
            $info->position = $key;
            $info->save();
        }
    }
}
