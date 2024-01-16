<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Movie;
use App\Models\Episode;
use App\Models\LinkMovie;
use Carbon\Carbon;

class EpisodeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    //ngăn chặn biết đường dân
    public function __construct()
    {
        $this->middleware('permission:publish episode|edit episode|add episode|delete episode',['only'=>['index','show']]);
        $this->middleware('permission:add episode',['only'=>['create','store']]);
        $this->middleware('permission:edit episode',['only'=>['edit','update']]);
        $this->middleware('permission:delete episode',['only'=>['destroy']]);
    }

    public function index()
    {
        $list = Episode::with('movie')->orderBy('episode','DESC')->get();
        return view('admin.episode.index',compact('list'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $linkmovie = LinkMovie::orderBy('id','DESC')->pluck('title','id');
        $list_server = LinkMovie::orderBy('id','DESC')->get();
        $list_movie = Movie::orderBy('id','DESC')->pluck('title','id','thuocphim');
        return view('admin.episode.form',compact('list_movie','linkmovie','list_server'));
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
        $episode_check = Episode::where('episode',$data['episode'])->where('movie_id',$data['movie_id'])->count();
        if($episode_check > 0){
            return redirect()->back()->with('status','Tập Phim Này Đã Có');
        }else{
            $ep = new Episode();
            $ep->movie_id = $data['movie_id'];
            $ep->linkphim = $data['link'];
            $ep->episode = $data['episode'];
            $ep->status = $data['status'];
            $ep->server = $data['linkserver'];
            $ep->created_at = Carbon::now('Asia/Ho_Chi_Minh');
            $ep->updated_at = Carbon::now('Asia/Ho_Chi_Minh');
            $ep->save();
        }
        toastr()->success('Thành Công','Thêm Tập Phim Thành Công');
        return redirect()->route('episode.index')->with('status','Thêm Thành Công');
    }

    public function add_episode($id){
        $linkmovie = LinkMovie::orderBy('id','DESC')->pluck('title','id');
        $list_server = LinkMovie::orderBy('id','DESC')->get();
        $movie = Movie::find($id);
        $list = Episode::with('movie')->where('movie_id',$id)->orderBy('episode','DESC')->get();
        return view('admin.episode.add_episode',compact('list','movie','linkmovie','list_server'));
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
        $linkmovie = LinkMovie::orderBy('id','DESC')->pluck('title','id');
        
         $list_movie = Movie::orderBy('id','DESC')->pluck('title','id');;
         $episode = Episode::find($id);
        return view('admin.episode.form',compact('episode','list_movie','linkmovie'));
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
        $ep = Episode::find($id);
        $ep->movie_id = $data['movie_id'];
        $ep->linkphim = $data['link'];
        $ep->episode = $data['episode'];
        $ep->status = $data['status'];
        $ep->server = $data['linkserver'];
        $ep->created_at = Carbon::now('Asia/Ho_Chi_Minh');
        $ep->updated_at = Carbon::now('Asia/Ho_Chi_Minh');
        $ep->save();
        toastr()->success('Thành Công','Cập Nhật Tập Phim Thành Công');
        return redirect()->to('add-episode/'.$ep->movie_id)->with('status','Cập Nhật Thành Công');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $episode = Episode::find($id)->delete();
        toastr()->success('Thành Công','Xóa Tập Phim Thành Công');
       return redirect()->route('episode.index')->with('status','Delete Thành Công');
    }
    public function select_episode(){
        
        $movie = Movie::find($_GET['id']);
        $output='<option>-----Chọn Tập Phim------</option>';
        if($movie->thuocphim=='phimbo'){
            for($i=1;$i<=$movie->sotap;$i++){
            $output.='<option value="'.$i.'">'.$i.'</option>';
            }
        }
        else{
            $output.='<option value="HD">HD</option><option value="FullHD">FullHD</option><option value="Cam">Cam</option><option value="HDCam">HDCam</option>';  
        }
                                
        
        echo $output;
    }
}
