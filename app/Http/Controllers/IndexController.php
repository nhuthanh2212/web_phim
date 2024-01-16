<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Genre;
use App\Models\Country;
use App\Models\Movie;
use App\Models\Episode;
use App\Models\Movie_Genre;
use App\Models\Movie_category;
use App\Models\Rating;
use App\Models\LinkMovie;
use App\Models\Info;
use DB;

class IndexController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function loc_phim(){

        
        $sapxep = $_GET['order'];
        $genre_get = $_GET['genre'];
        $country_get = $_GET['country'];
        $year_get = $_GET['year_locphim'];


        if($sapxep == '' && $country_get == '' && $genre_get == '' && $year_get == ''){
             return redirect()->back();
        }
        else{
            $meta_title="Lọc Theo Phim. ";
            $meta_description="Lọc Theo Phim.";
            $meta_image = "";

            $movie_array = Movie::withCount('episode');
            
            if($country_get){
                $movie_array = $movie_array->where('country_id',$country_get);
            }
            elseif($year_get){
                $movie_array = $movie_array->where('year',$year_get);   
            }
            elseif($sapxep){
                $movie_array = $movie_array->orderBy($sapxep,'DESC');
            }
            $movie_array = $movie_array->with('movie_genre');
            $movie = array();

            foreach($movie_array as $mov){
                foreach($mov->movie_genre as $mov_gen){
                    $movie = $movie_array->whereIn('genre_id',[$mov_gen->genre_id]);
                }
            }

            $movie = $movie_array->paginate(40);

            return view('pages.locphim',compact('movie','meta_title','meta_description','meta_image'));
        }
    }

    public function timkiem(){
            $meta_title="Lọc Theo Phim. ";
            $meta_description="Lọc Theo Phim.";
            $meta_image = "";
        if(isset($_GET['search'])){
            $search = $_GET['search'];
            
            $movie = Movie::withCount('episode')->where('title','LIKE','%'.$search.'%')->paginate(20);
            return view('pages.timkiem',compact('movie','search','meta_title','meta_description','meta_image'));
        }
        else{
            return redirect()->to('/');
        }
        
    }

    public function index()
    {
        $info = Info::find(2);
        $meta_title = $info->title;
        $meta_description = $info->description;
        $meta_image = '';
        $phimhot = Movie::withCount('episode')->where('phim_hot',1)->where('status', 1)->orderBy('ngaycapnhat','DESC')->get();
        
        $category_home = Category::with(['movie' => function($q){
            $q->withCount('episode')->where('status',1);
        }])->orderBy('position','ASC')->where('status',1)->get();
        return view('pages.home',compact('category_home','phimhot','meta_title','meta_description','meta_image'));
    }

    public function category($slug)
    {
        
        $cate_slug = Category::where('slug',$slug)->first();
        $meta_title = $cate_slug->title;
        $meta_description = $cate_slug->description;
        $meta_image = '';
        //nhieu danh muc
        $movie_category = Movie_category::where('category_id',$cate_slug->id)->get();
        $many_category = [];
        foreach($movie_category as $key => $movi){
            $many_category[] = $movi->movie_id;
        }
       
        $movie = Movie::withCount(['episode'=>function($q)
        {
            $q->where('server',3);
        }
        ])->whereIn('id',$many_category)->orderBy('ngaycapnhat','DESC')->paginate(40);

        
        
        return view('pages.category',compact('cate_slug','movie','meta_title','meta_description','meta_image'));
    }
    public function year($year)
    {
        $meta_title = 'Năm Phim: '.$year;
        $meta_description = 'Tìm Năm Phim: '.$year;
        $meta_image = '';

        $year = $year;
        
        $movie = Movie::withCount('episode')->where('year',$year)->orderBy('ngaycapnhat','DESC')->paginate(40);
        return view('pages.year',compact('movie','year','meta_title','meta_description','meta_image'));
    }
    public function tag($tag){
        
         $meta_title = $tag;
        $meta_description = $tag;
        $meta_image = '';

        $tag = $tag;
       
        $movie = Movie::withCount('episode')->where('tags','LIKE','%'.$tag.'%')->orderBy('ngaycapnhat','DESC')->paginate(40);
        return view('pages.tag',compact('movie','tag','meta_title','meta_description','meta_image'));
    }

    public function genre($slug)
    {
     
         $genre_slug = Genre::where('slug',$slug)->first();
        $meta_title = $genre_slug->title;
        $meta_description = $genre_slug->description;
        $meta_image = '';
        //nhieu the loai
        $movie_genre = Movie_Genre::where('genre_id',$genre_slug->id)->get();
        $many_genre = [];
        foreach($movie_genre as $key => $movi){
            $many_genre[] = $movi->movie_id;
        }
        if(isset($_GET['phimle'])){
            $movie = Movie::withCount(['episode'=>function($q){
                $q->where('server',3);
            }

        ])->where('thuocphim','phimle')->whereIn('id',$many_genre)->orderBy('ngaycapnhat','DESC')->paginate(40);

        }else
        {
            $movie = Movie::withCount(['episode'=>function($q){
                $q->where('server',3);
            }])->whereIn('id',$many_genre)->orderBy('ngaycapnhat','DESC')->paginate(40);
        }
        
        return view('pages.genre',compact('genre_slug','movie','meta_title','meta_description','meta_image'));
    }

    public function country($slug)
    {
        
        $count_slug = Country::where('slug',$slug)->first();
        $meta_title = $count_slug->title;
        $meta_description = $count_slug->description;
        $meta_image = '';

        $movie = Movie::withCount('episode')->where('country_id',$count_slug->id)->orderBy('ngaycapnhat','DESC')->paginate(40);
        return view('pages.country',compact('count_slug','movie','meta_title','meta_description','meta_image'));
    }

    public function movie($slug)
    {
        
        $movie = Movie::with('category','genre','country','movie_genre')->where('slug',$slug)->where('status',1)->first();
        $meta_title = $movie->title;
        $meta_description = $movie->description;
        $meta_image = url('uploads/movie/'.$movie->image);

        //lay tap 1
        $episode_tapdau = Episode::with('movie')->where('movie_id',$movie->id)->orderBy('episode','ASC')->take(1)->first();
        //phim lien quan
        $related = Movie::with('category','genre','country')->where('category_id',$movie->category->id)->orderBy(DB::raw('RAND()'))->whereNotIn('slug',[$slug])->get();
        //lay 3 tap gan nhat
        $episode = Episode::with('movie')->where('movie_id',$movie->id)->orderBy('episode','DESC')->take(3)->get();
        //lay tong tap phim da them 
        $episode_current_list = Episode::with('movie')->where('movie_id',$movie->id)->get();
        $episode_current_list_count = $episode_current_list->count();

        // rating movie
        $rating = Rating::where('movie_id',$movie->id)->avg('rating');
        $rating = round($rating);
        $count_total = Rating::where('movie_id',$movie->id)->count();


        //tang view phim
        $count_views = $movie->count_views;
        $count_views = $count_views + 1;
        $movie->count_views = $count_views;
        $movie->save();

        

        return view('pages.movie',compact('movie','related','episode','episode_tapdau','episode_current_list_count','rating','count_total','meta_title','meta_description','meta_image'));
    }

    public function add_rating(Request $request){
        $data = $request->all();
        $ip_address = $request->ip();

        $rating_count = Rating::where('movie_id',$data['movie_id'])->where('ip_address',$ip_address)->count();
        if($rating_count > 0){
            echo 'exist';
        }else
        {
            $rating = new Rating();
            $rating->movie_id = $data['movie_id'];
            $rating->rating = $data['index'];
            $rating->ip_address = $ip_address;
            $rating->save();
            echo 'done';
        }
    }

    public function watch($slug,$tap,$server_active)
    {

         

        

        $movie = Movie::with('category','genre','country','movie_genre','movie_category','episode')->where('slug',$slug)->where('status',1)->first();
        $meta_title = 'Xem Phim: '.$movie->title;
        $meta_description = $movie->description;
        $meta_image = url('uploads/movie/'.$movie->image);
        
        //phim lien quan
         $related = Movie::with('category','genre','country')->where('category_id',$movie->category->id)->orderBy(DB::raw('RAND()'))->whereNotIn('slug',[$slug])->get();
        //lay tap 1
       if(isset($tap)){
            $tapphim = $tap;
            $tapphim = substr($tap,4,20);
            $episode = Episode::where('movie_id',$movie->id)->where('episode',$tapphim)->first();
        }
        else{
             $tapphim = 1;
             $episode = Episode::where('movie_id',$movie->id)->where('episode',$tapphim)->first();
        }

        
        $server = LinkMovie::orderBy('id','DESC')->get();
        $server_movie = Episode::where('movie_id',$movie->id)->get()->unique('server');
        $server_movie_list = Episode::where('movie_id',$movie->id)->orderBy('episode','ASC')->get();

        return view('pages.watch',compact('movie','episode','tapphim','related','meta_title','meta_description','meta_image','server','server_movie','server_movie_list','server_active'));
    }

    public function episode()
    {
        return view('pages.episode');
    }

    
}
