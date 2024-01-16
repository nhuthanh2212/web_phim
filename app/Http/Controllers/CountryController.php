<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Country;
class CountryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        $this->middleware('permission:publish country|edit country|add country|delete country',['only'=>['index','show']]);
        $this->middleware('permission:add country',['only'=>['create','store']]);
        $this->middleware('permission:edit country',['only'=>['edit','update']]);
        $this->middleware('permission:delete country',['only'=>['destroy']]);
    }
    public function index()
    {
        $list = Country::orderBy('position','ASC')->get();
        return view('admin.country.index',compact('list'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
        return view('admin.country.form');
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
            'title' => 'required|unique:countries|max:255',
           
            'slug' => 'required|unique:countries|max:255',
            'description' => 'required|max:255',
            
            'position' => 'required',
            'status' => 'required',

            
        ],
        [
            'title.unique' => 'Tên Danh Mục này đã có, vui lòng điền tên khác',
            'title.required' => 'Tên Danh Mục Phải Có',
            'status.required' => 'Trạng Thái Quốc Gia Phải Có',
            'description.required' => 'Mô Tả Danh Mục Phải Có',
            'position.required' => 'Thứ Tự Danh Mục Phải Có',
            
            
        ]);
        $country = new Country();
        $country->title = $data['title'];
        $country->slug = $data['slug'];
        $country->description = $data['description'];
        $country->position = $data['position'];
        $country->status = $data['status'];
        $country->save();
        toastr()->success('Thành Công','Thêm Quốc Gia Phim Thành Công');
        return redirect()->route('country.index')->with('status','Thêm Thành Công');
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
        $country = Country::find($id);
       
        return view('admin.country.form',compact('country'));
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
            'title' => 'required|unique:countries|max:255',
           
            'slug' => 'required|unique:countries|max:255',
            'description' => 'required|max:255',
            
            'position' => 'required',
            'status' => 'required',
            
        ],
        [
            'title.unique' => 'Tên Danh Mục này đã có, vui lòng điền tên khác',
            'title.required' => 'Tên Danh Mục Phải Có',
            
            'description.required' => 'Mô Tả Danh Mục Phải Có',
            'position.required' => 'Thứ Tự Danh Mục Phải Có',
            'status.required' => 'Trạng Thái Quốc Gia Phải Có',

            
            
        ]);
        $country = Country::find($id);
        $country->title = $data['title'];
        $country->slug = $data['slug'];
        $country->description = $data['description'];
        $country->position = $data['position'];
        $country->status = $data['status'];
        $country->save();
        toastr()->success('Thành Công','Cập Nhật Quốc Gia Phim Thành Công');
        return redirect()->route('country.index')->with('status','Cập Nhật Thành Công');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Country::find($id)->delete();
        toastr()->success('Thành Công','Xóa Quốc Gia Phim Thành Công');
        return redirect()->route('country.index')->with('status','Delete Thành Công');

    }
    public function resorting_country(Request $request){
        $data = $request->all();
        foreach($data['array_id'] as $key => $value){
            $country = Country::find($value);
            $country->position = $key;
            $country->save();
        }
    }
}
