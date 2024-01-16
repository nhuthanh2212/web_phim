<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\LinkMovie;

class LinkMovieController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    //ngăn chặn biết đường dân
    public function __construct()
    {
        $this->middleware('permission:publish linkmovie|edit linkmovie|add linkmovie|delete linkmovie',['only'=>['index','show']]);
        $this->middleware('permission:add linkmovie',['only'=>['create','store']]);
        $this->middleware('permission:edit linkmovie',['only'=>['edit','update']]);
        $this->middleware('permission:delete linkmovie',['only'=>['destroy']]);
    }

    public function index()
    {
        $list = LinkMovie::orderBy('position','ASC')->get();
        return view('admin.linkmovie.index',compact('list'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.linkmovie.form');
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
            'title' => 'required|unique:linkmovie|max:255',
           
            
            'description' => 'required|max:255',
            
            'position' => 'required',
            'status' => 'required',
        ],
        [
            'title.unique' => 'Tên Link này đã có, vui lòng điền tên khác',
            'title.required' => 'Tên Link Phải Có',
            
            'description.required' => 'Mô Tả Link Phải Có',
            'position.required' => 'Thứ Tự Link Phải Có',
            'status.required' => 'Trạng Thái Link Phải Có',
            
        ]);
        $linkmovie = new LinkMovie();
        $linkmovie->title = $data['title'];
        
        $linkmovie->position = $data['position'];
        $linkmovie->description = $data['description'];
        $linkmovie->status = $data['status'];
        $linkmovie->save();
         toastr()->info('Thành Công','Thêm Link Phim Thành Công');
        return redirect()->route('linkmovie.index')->with('status','Thêm Thành Công');
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
        $linkmovie = LinkMovie::find($id);
        return view('admin.linkmovie.form',compact('linkmovie'));
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
            'title' => 'required|unique:LinkMovie|max:255',
           
            
            'description' => 'required|max:255',
            'status' => 'required',
            'position' => 'required',
            
        ],
        [
            'title.unique' => 'Tên Link này đã có, vui lòng điền tên khác',
            'title.required' => 'Tên Link Phải Có',
            
            'description.required' => 'Mô Tả Link Phải Có',
            'position.required' => 'Thứ Tự Link Phải Có',
            
            'status.required' => 'Trạng Thái Link Phải Có',
            
        ]);
        $linkmovie = LinkMovie::find($id);
        $linkmovie->title = $data['title'];
        $linkmovie->position = $data['position'];
       
        $linkmovie->description = $data['description'];
        $linkmovie->status = $data['status'];
        $linkmovie->save();
        toastr()->success('Thành Công','Cập Nhật Link Phim Thành Công');
        return redirect()->route('linkmovie.index')->with('status','Cập Nhật Thành Công');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        LinkMovie::find($id)->delete();
        toastr()->success('Thành Công','Xóa Link Phim Thành Công');
       return redirect()->route('linkmovie.index')->with('status','Delete Thành Công');
    }
    public function resorting_linkmovie(Request $request){
        $data = $request->all();
        foreach($data['array_id'] as $key => $value){
            $linkmovie = LinkMovie::find($value);
            $linkmovie->position = $key;
            $linkmovie->save();
        }
    }
}
