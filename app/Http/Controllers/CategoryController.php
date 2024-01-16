<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
//chặn khi người khách nhập đúng đường dẫn
    public function __construct()
    {
        $this->middleware('permission:publish category|edit category|add category|delete category',['only'=>['index','show']]);
        $this->middleware('permission:add category',['only'=>['create','store']]);
        $this->middleware('permission:edit category',['only'=>['edit','update']]);
        $this->middleware('permission:delete category',['only'=>['destroy']]);
    }

    public function index()
    {
        $list = Category::orderBy('position','ASC')->get();
        return view('admin.category.index',compact('list'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
        return view('admin.category.form');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // $data = $request->all();
        $data = $request->validate([
            'title' => 'required|unique:categories|max:255',
           
            'slug' => 'required|unique:categories|max:255',
            'description' => 'required|max:255',
            
            'position' => 'required',
            'status' => 'required',
        ],
        [
            'title.unique' => 'Tên Danh Mục này đã có, vui lòng điền tên khác',
            'title.required' => 'Tên Danh Mục Phải Có',
            
            'description.required' => 'Mô Tả Danh Mục Phải Có',
            'position.required' => 'Thứ Tự Danh Mục Phải Có',
            'status.required' => 'Trạng Thái Danh Mục Phải Có',
            
        ]);
        $category = new Category();
        $category->title = $data['title'];
        $category->slug = $data['slug'];
        $category->position = $data['position'];
        $category->description = $data['description'];
        $category->status = $data['status'];
        $category->save();
         toastr()->info('Thành Công','Thêm Danh Mục Phim Thành Công');
        return redirect()->route('category.index')->with('status','Thêm Thành Công');

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
        $category = Category::find($id);
        return view('admin.category.form',compact('category'));
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
        // $data = $request->all();
        $data = $request->validate([
            'title' => 'required|unique:categories|max:255',
           
            'slug' => 'required|unique:categories|max:255',
            'description' => 'required|max:255',
            'status' => 'required',
            'position' => 'required',
            
        ],
        [
            'title.unique' => 'Tên Danh Mục này đã có, vui lòng điền tên khác',
            'title.required' => 'Tên Danh Mục Phải Có',
            
            'description.required' => 'Mô Tả Danh Mục Phải Có',
            'position.required' => 'Thứ Tự Danh Mục Phải Có',
            
            'status.required' => 'Trạng Thái Danh Mục Phải Có',
            
        ]);
        $category = Category::find($id);
        $category->title = $data['title'];
        $category->position = $data['position'];
        $category->slug = $data['slug'];
        $category->description = $data['description'];
        $category->status = $data['status'];
        $category->save();
        toastr()->success('Thành Công','Cập Nhật Danh Mục Phim Thành Công');
        return redirect()->route('category.index')->with('status','Cập Nhật Thành Công');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Category::find($id)->delete();
        toastr()->success('Thành Công','Xóa Danh Mục Phim Thành Công');
       return redirect()->route('category.index')->with('status','Delete Thành Công');
        
    }
    public function resorting_category(Request $request){
        $data = $request->all();
        foreach($data['array_id'] as $key => $value){
            $category = Category::find($value);
            $category->position = $key;
            $category->save();
        }
    }
}
