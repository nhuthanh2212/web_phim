<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;
use App\Models\Movie;
use App\Models\Category;
use App\Models\Country;
use App\Models\Genre;
use App\Models\Episode;
use App\Models\LinkMovie;
use Carbon\Carbon;

class LeechMovieController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    //ngăn chặn biết đường dân
    public function __construct()
    {
        $this->middleware('permission:publish leech|edit leech|add leech|delete leech',['only'=>['leech_movie','leech_episodes','leech_detail']]);
        $this->middleware('permission:add leech',['only'=>['leech_store']]);
        $this->middleware('permission:add leech episode',['only'=>['leech_episode_store']]);
        
    }
    

    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
    public function leech_movie(){
        $resp = Http::get("https://ophim1.com/danh-sach/phim-moi-cap-nhat?page=1")->json();
        return view('admin.leech.index',compact('resp'));
    }

     public function leech_episodes($slug){
       $resp = Http::get("https://ophim1.com/phim/".$slug)->json();
        
        return view('admin.leech.leech_episode',compact('resp'));
    }

    public function leech_detail($slug){
        $resp = Http::get("https://ophim1.com/phim/".$slug)->json();
        $resp_movie[] = $resp['movie']; 
        return view('admin.leech.leech_detail',compact('resp_movie'));
    }
    public function leech_store(Request $request, $slug){
        $resp = Http::get("https://ophim1.com/phim/".$slug)->json();
        $resp_movie[] = $resp['movie']; 
        $movie = new Movie();
        foreach($resp_movie as $key => $res){
            $movie->title = $res['name'];

            $movie->sotap = $res['episode_total'];
            $movie->tags = $res['name'].','.$res['slug'];
            $movie->thoiluong = $res['time'];
            $movie->slug = $res['slug'];
            $movie->name_eng = $res['origin_name'];
            $movie->description = $res['content'];
            $movie->status = 1;
            $trailerurl = $res['trailer_url'];
            $movie->trailer = str_replace("https://www.youtube.com/watch?v=", "", $trailerurl);
            $movie->resolution = 0;
            $movie->phude = 0;
            $movie->thuocphim = 'phimle';
            $movie->phim_hot = 1;
            $movie->year = $res['year'];
          
            $movie->count_views = rand(100,99999);
            $category = Category::orderBy('id','DESC')->first();
            $movie->category_id = $category->id;
            
            $country = Country::orderBy('id','DESC')->first();
            $movie->country_id = $country->id;

            $genre = Genre::orderBy('id','DESC')->first();
            $movie->genre_id = $genre->id;

            $movie->ngaytao = Carbon::now('Asia/Ho_Chi_Minh');
            $movie->ngaycapnhat = Carbon::now('Asia/Ho_Chi_Minh');
            $movie->image = $res['thumb_url'];
           
            $movie->save();
             $movie->movie_genre()->attach($genre); 
            $movie->movie_category()->attach($category);
        }
        toastr()->success('Thành Công','Thêm Phim Thành Công'); 
        return redirect()->route('movie.index')->with('status','Thêm Thành Công');
    }

    public function leech_episode_store(Request $request,$slug){
        $movie = Movie::where('slug',$slug)->first();
        Episode::where('movie_id', $movie->id)->delete();
        $resp = Http::get("https://ophim1.com/phim/".$slug)->json();
        foreach($resp['episodes'] as $key => $res){
            foreach($res['server_data'] as $key_date => $res_data)
            {
                $check_Episode = Episode::where('movie_id', $movie->id)
                ->where('linkphim', $res_data['link_embed'])
                ->first();

                if (!$check_Episode) {
                    $ep = new Episode();
                    $ep->movie_id = $movie->id;
                    $ep->linkphim = '<p><iframe allowfullscreen frameborder="0" height="360" scrolling="0" src="'.$res_data['link_embed'].'" with="100%"></iframe></p>';
                    $ep->episode = $res_data['name'];

                    if ($key_date == 0) {
                        $linkmovie = LinkMovie::orderBy('id', 'DESC')->first();
                        $ep->server = $linkmovie->id;
                    } else {
                        $linkmovie = LinkMovie::orderBy('id', 'ASC')->first();
                        $ep->server = $linkmovie->id;
                    }

                    $ep->status = 1;
                    $ep->created_at = Carbon::now('Asia/Ho_Chi_Minh');
                    $ep->updated_at = Carbon::now('Asia/Ho_Chi_Minh');
                    $ep->save();
                }
                
            }
        }
        toastr()->success('Thành Công','Thêm Tập Phim Thành Công'); 
        return redirect()->route('leech-movie');
    }
    
}
