<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Genre;
class GenreController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    //bảo vệ k cho gõ đường dẫn
    public function __construct()
    {
        $this->middleware('permission:publish genre|edit genre|add genre|delete genre',['only'=>['index','show']]);
        $this->middleware('permission:add genre',['only'=>['create','store']]);
        $this->middleware('permission:edit genre',['only'=>['edit','update']]);
        $this->middleware('permission:delete genre',['only'=>['destroy']]);
    }

    public function index()
    {
        $list = Genre::orderBy('position','ASC')->get();
        return view('admin.genre.index',compact('list'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
       
        return view('admin.genre.form');
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
            'title' => 'required|unique:genres|max:255',
           
            'slug' => 'required|unique:genres|max:255',
            'description' => 'required|max:255',
            'status' => 'required',

            'position' => 'required',
            
        ],
        [
            'title.unique' => 'Tên Danh Mục này đã có, vui lòng điền tên khác',
            'title.required' => 'Tên Danh Mục Phải Có',
            'status.required' => 'Trạng Thái Thể Loại Phải Có',
            'description.required' => 'Mô Tả Danh Mục Phải Có',
            'position.required' => 'Thứ Tự Danh Mục Phải Có',
            
            
        ]);
        $genre = new Genre();
        $genre->title = $data['title'];
        $genre->slug = $data['slug'];
        $genre->description = $data['description'];
        $genre->position = $data['position'];
        $genre->status = $data['status'];
        $genre->save();
        toastr()->success('Thành Công','Thêm Thể Loại Phim Thành Công');
        return redirect()->route('genre.index')->with('status','Thêm Thành Công');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
       
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $genre = Genre::find($id);
        
        return view('admin.genre.form',compact('genre'));
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
            'title' => 'required|unique:genres|max:255',
           
            'slug' => 'required|unique:genres|max:255',
            'description' => 'required|max:255',
            'status' => 'required',

            'position' => 'required',
            
        ],
        [
            'title.unique' => 'Tên Danh Mục này đã có, vui lòng điền tên khác',
            'title.required' => 'Tên Danh Mục Phải Có',
            'status.required' => 'Trạng Thái Thể Loại Phải Có',
            'description.required' => 'Mô Tả Danh Mục Phải Có',
            'position.required' => 'Thứ Tự Danh Mục Phải Có',
            
            
        ]);
        $genre = Genre::find($id);
        $genre->title = $data['title'];
        $genre->slug = $data['slug'];
        $genre->description = $data['description'];
        $genre->position = $data['position'];
        $genre->status = $data['status'];
        $genre->save();
        toastr()->success('Thành Công','Cập Nhật Thể Loại Phim Thành Công');
        return redirect()->route('genre.index')->with('status','Cập Nhật Thành Công');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Genre::find($id)->delete();
        toastr()->success('Thành Công','Xóa Thể Loại Phim Thành Công');
        return redirect()->route('genre.index')->with('status','Delete Thành Công');
    }
    public function resorting_genre(Request $request){
        $data = $request->all();
        foreach($data['array_id'] as $key => $value){
            $genre = Genre::find($value);
            $genre->position = $key;
            $genre->save();
        }
    }
}
