<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Movie;
use App\Models\Category;
use App\Models\Genre;
use App\Models\Country;
use Carbon\Carbon;
use App\Models\Movie_Genre;
use App\Models\Movie_category;
use App\Models\Episode;
use App\Models\Info;
use File;

class MovieController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function __construct()
    {
        $this->middleware('permission:publish moviee|edit moviee|add moviee|delete moviee',['only'=>['index','show']]);
        $this->middleware('permission:add moviee',['only'=>['create','store']]);
        $this->middleware('permission:edit moviee',['only'=>['edit','update']]);
        $this->middleware('permission:delete moviee',['only'=>['destroy']]);
    }
    public function sort_movie(){
        $category = Category::orderBy('position','ASC')->get();
        $category_home = Category::with(['movie' => function($q){
            $q->withCount('episode')->where('status',1);
        }])->orderBy('position','ASC')->where('status',1)->get();
        return view('admin.movie.sort_movie',compact('category','category_home'));
    }
    public function resorting_movie(Request $request){
         $data = $request->all();
        foreach($data['array_id'] as $key => $value){
            $movie = Movie::find($value);
            $movie->position = $key;
            $movie->save();
        }
    }
    public function resorting_navbar(Request $request){
        $data = $request->all();
        foreach($data['array_id'] as $key => $value){
            $category = Category::find($value);
            $category->position = $key;
            $category->save();
        }
    }

    public function index()
    {
        $list = Movie::with('category','movie_genre','country','genre')->withCount('episode')->orderBy('id','DESC')->get();
        $category = Category::pluck('title','id');
        $country = Country::pluck('title','id');
        $destinationPath=public_path()."/json_file/";
        if(!is_dir($destinationPath)){
            mkdri($destinationPath,0777,true);
        }
        File::put($destinationPath.'movies.json',json_encode($list));
        return view('admin.movie.index',compact('list','category','country'));
    }
    public function category_choose(Request $request){
        $data = $request->all();
        $movie = Movie::find($data['movie_id']);
        $movie->category_id = $data['category_id'];
        $movie->save();

    }
    public function country_choose(Request $request){
        $data = $request->all();
        $movie = Movie::find($data['movie_id']);
        $movie->country_id = $data['country_id'];
        $movie->save();

    }

    public function phimhot_choose(Request $request){
        $data = $request->all();
        $movie = Movie::find($data['movie_id']);
        $movie->phim_hot = $data['phimhot_val'];
        $movie->save();

    }

     public function phude_choose(Request $request){
        $data = $request->all();
        $movie = Movie::find($data['movie_id']);
        $movie->phude = $data['phude_val'];
        $movie->save();

    }

    public function trangthai_choose(Request $request){
        $data = $request->all();
        $movie = Movie::find($data['movie_id']);
        $movie->status = $data['status_val'];
        $movie->save();

    }

    public function thuocphim_choose(Request $request){
        $data = $request->all();
        $movie = Movie::find($data['movie_id']);
        $movie->thuocphim = $data['thuocphim_val'];
        $movie->save();

    }

    public function dinhdang_choose(Request $request){
        $data = $request->all();
        $movie = Movie::find($data['movie_id']);
        $movie->resolution = $data['dinhdang_val'];
        $movie->save();

    }

    public function update_image_movie_ajax(Request $request){
        $get_image = $request->file('file');
        $movie_id = $request->movie_id;
        if($get_image){
            //xóa ảnh củ
            $movie = Movie::find($movie_id);
            unlink('uploads/movie/'.$movie->image);
            // thêm ảnh mới
            $get_name_image = $get_image->getClientOriginalName();
            $name_image = current(explode('.',$get_name_image));
            $new_image = $name_image.rand(0,9999).'.'.$get_image->getClientOriginalExtension();
            $get_image->move('uploads/movie/',$new_image);
            $movie->image = $new_image;
            $movie->save();
        }
    }

    public function update_year(Request $request){
        $data = $request->all();
        $movie = Movie::find($data['id_phim']);
        $movie->year = $data['year'];
        $movie->save();
    }

    public function update_season(Request $request){
        $data = $request->all();
        $movie = Movie::find($data['id_phim']);
        $movie->season = $data['season'];
        $movie->save();
    }

    public function update_topview(Request $request){
        $data = $request->all();
        $movie = Movie::find($data['id_phim']);
        $movie->topview = $data['topview'];
        $movie->save();
    }
    public function filter_topview(Request $request){
        $data = $request->all();
        $movie = Movie::where('topview',$data['value'])->orderBy('ngaycapnhat','DESC')->take(5)->get();
        $output = '';
        foreach($movie as $key => $mov){
            if($mov->resolution==0){
                $text = 'HD';
            }
            elseif($mov->resolution==1){
                $text = 'SD';
            }
            elseif($mov->resolution==2){
                $text = 'HDCam';
            }
            elseif($mov->resolution==3){
                $text = 'Cam';
            }
            elseif($mov->resolution==4){
                $text = 'FullHD';
            }
            else{
                $text = 'Trailer';
            }
            $output.='<div class="item">
                              <a href="'.url('phim/'.$mov->slug).'" title="'.$mov->title.'">
                                 <div class="item-link">
                                    <img src="'.$mov->image.'" class="lazy post-thumb" alt="'.$mov->title.'" title="'.$mov->title.'" />
                                    <span class="is_trailer">
                                        '.$text.'
                                    </span>
                                 </div>
                                 <p class="title">'.$mov->title.'</p>
                              </a>
                              <div class="viewsCount" style="color: #9d9d9d;">
                                    '.$mov->year.'
                                 </div>
                              <div class="viewsCount" style="color: #9d9d9d;">'.$mov->count_views.' lượt xem</div>
                              <div style="float: left;">
                                <ul class="list-inline rating"  title="Average Rating">';
                                          for($count=1; $count<=5; $count++){

                                          $output.='<li title="star_rating" style="font-size:20px; color: #ffcc00; padding: 0">&#9733;</li>';
                                          }
                                       $output.='</ul>

                                       
                                 </div>
                           </div>';
        }
        echo $output;
    }

    public function filter_default(Request $request){
        $data = $request->all();
        $movie = Movie::where('topview',0)->orderBy('ngaycapnhat','DESC')->take(5)->get();
        $output = '';
        foreach($movie as $key => $mov){
            if($mov->resolution==0){
                $text = 'HD';
            }
            elseif($mov->resolution==1){
                $text = 'SD';
            }
            elseif($mov->resolution==2){
                $text = 'HDCam';
            }
            elseif($mov->resolution==3){
                $text = 'Cam';
            }
            elseif($mov->resolution==4){
                $text = 'FullHD';
            }
            else{
                $text = 'Trailer';
            }
            $output.='<div class="item">
                              <a href="'.url('phim/'.$mov->slug).'" title="'.$mov->title.'">
                                 <div class="item-link">
                                    <img src="'.$mov->image.'" class="lazy post-thumb" alt="'.$mov->title.'" title="'.$mov->title.'" />
                                    <span class="is_trailer">'.$text.'
                                    </span>
                                 </div>
                                 <p class="title">'.$mov->title.'</p>
                              </a>
                              <div class="viewsCount" style="color: #9d9d9d;">
                                    '.$mov->year.'
                                 </div>
                              <div class="viewsCount" style="color: #9d9d9d;">'.$mov->count_views.' lượt xem</div>
                              <div style="float: left;">
                                 <ul class="list-inline rating"  title="Average Rating">';
                                          for($count=1; $count<=5; $count++){

                                          $output.='<li title="star_rating" style="font-size:20px; color: #ffcc00; padding: 0">&#9733;</li>';
                                          }
                                       $output.='</ul>
                              </div>
                           </div>';
        }
        echo $output;
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $category = Category::pluck('title','id');
        $genre = Genre::pluck('title','id');
        $list_genre = Genre::all();
        $list_cate = Category::all();
        $country = Country::pluck('title','id');
        return view('admin.movie.form',compact('category','genre','country', 'list_genre','list_cate'));
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
        $movie = new Movie();
        $movie->title = $data['title'];
        $movie->sotap = $data['sotap'];
        $movie->tags = $data['tags'];
        $movie->thoiluong = $data['thoiluong'];
        $movie->slug = $data['slug'];
        $movie->name_eng = $data['name_eng'];
        $movie->description = $data['description'];
        $movie->status = $data['status'];
        $movie->trailer = $data['trailer'];
        $movie->resolution = $data['resolution'];
        $movie->phude = $data['phude'];
        $movie->thuocphim = $data['thuocphim'];
        $movie->phim_hot = $data['phim_hot'];
        
        $movie->country_id = $data['country_id'];
        $movie->count_views = rand(100,99999);
        foreach($data['genre'] as $key => $gen ){
            $movie->genre_id = $gen[0];
        }

        foreach($data['category'] as $key => $cate ){
            $movie->category_id = $cate[0];
        }
        

        $movie->ngaytao = Carbon::now('Asia/Ho_Chi_Minh');
        $movie->ngaycapnhat = Carbon::now('Asia/Ho_Chi_Minh');

        //thêm ảnh
        $get_image = $request->file('image');
       

        $path = 'uploads/movie/';
        if($get_image){
            $get_name_image = $get_image->getClientOriginalName();
            $name_image = current(explode('.',$get_name_image));
            $new_image = $name_image.rand(0,9999).'.'.$get_image->getClientOriginalExtension();
            $get_image->move($path,$new_image);
            $movie->image = $new_image;
        }
        $movie->save();
        //them nhieu the loai cho phim
        $movie->movie_genre()->attach($data['genre']); 
        $movie->movie_category()->attach($data['category']);


        toastr()->success('Thành Công','Thêm Phim Thành Công'); 
       return redirect()->route('movie.index')->with('status','Thêm Thành Công');
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
        $category = Category::pluck('title','id');
        $genre = Genre::pluck('title','id');
        $list_genre = Genre::all();
        $country = Country::pluck('title','id');
        $list_cate = Category::all();
        $movie = Movie::find($id);
        $movie_genre = $movie->movie_genre;
        $movie_category = $movie->movie_category;
        return view('admin.movie.form',compact('category','genre','country','movie','list_genre','movie_genre','list_cate','movie_category'));
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
        // return response()->json($data['genre']);
        $movie = Movie::find($id);
        $movie->title = $data['title'];
        $movie->sotap = $data['sotap'];
        $movie->tags = $data['tags'];
        $movie->thoiluong = $data['thoiluong'];
        $movie->slug = $data['slug'];
        $movie->name_eng = $data['name_eng'];
        $movie->description = $data['description'];
        $movie->trailer = $data['trailer'];
        $movie->status = $data['status'];
        $movie->resolution = $data['resolution'];
        $movie->phude = $data['phude'];
        $movie->thuocphim = $data['thuocphim'];
        $movie->resolution = $data['resolution'];
        $movie->phim_hot = $data['phim_hot'];
        
        $movie->country_id = $data['country_id'];

        // $movie->count_views = rand(100,99999);

        
        foreach($data['genre'] as $key => $gen ){
            $movie->genre_id = $gen[0];
        }

        foreach($data['category'] as $key => $cate ){
            $movie->category_id = $cate[0];
        }
        
        $movie->ngaycapnhat = Carbon::now('Asia/Ho_Chi_Minh');

        //thêm ảnh
        $get_image = $request->file('image');
       

       
        if($get_image){
            $path_unlink = 'uploads/movie/'.$movie->image;
            if(file_exists($path_unlink)){
                unlink($path_unlink);
            }
            $path = 'uploads/movie/';
            $get_name_image = $get_image->getClientOriginalName();
            $name_image = current(explode('.',$get_name_image));
            $new_image = $name_image.rand(0,9999).'.'.$get_image->getClientOriginalExtension();
            $get_image->move($path,$new_image);
            $movie->image = $new_image;
        }
        $movie->save();
        $movie->movie_genre()->sync($data['genre']); 
        $movie->movie_category()->sync($data['category']);

        toastr()->success('Thành Công','Cập Nhật Phim Thành Công');
        return redirect()->route('movie.index')->with('status','Cập Nhật Thành Công');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $movie = Movie::find($id);
        //xoa anh
        $path_unlink = 'uploads/movie/'.$movie->image;
            if(file_exists($path_unlink)){
                unlink($path_unlink);
            }
        //xoa the loai
         Movie_Genre::whereIn('movie_id',[$movie->id])->delete();
         // xoa tap phim
         Episode::whereIn('movie_id',[$movie->id])->delete();
        // $movie->delete();
        $movie->movie_genre()->detach($movie->genre_id); 
        $movie->movie_category()->detach($movie->category_id);

        Movie::find($id)->delete();

        toastr()->success('Thành Công','Xóa Phim Thành Công');
        return redirect()->route('movie.index')->with('status','Delete Thành Công');
    }
    public function watch_video(Request $request){
        $data = $request->all();
        $movie = Movie::find($data['movie_id']);
        $video = Episode::where('movie_id',$data['movie_id'])->where('episode',$data['episode_id'])->first();
        
        $output['video_title'] = $movie->title.'- Tập '.$video->episode;
        $output['video_desc'] = $movie->description;
        
        $output['video_link'] = $video->linkphim;

        echo json_encode($output);
    }
}
