<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use Illuminate\Support\Facades\View;

use App\Models\Category;
use App\Models\Genre;
use App\Models\Country;
use App\Models\Movie;
use App\Models\Episode;
use App\Models\Movie_Genre;
use App\Models\Rating;
use App\Models\Info;
use DB;
use Carbon\Carbon;
class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $info = Info::find(2);
        $phimhot_sidebar = Movie::where('phim_hot',1)->where('status', 1)->orderBy('ngaycapnhat','DESC')->take(5)->get();
        $phimhot_trailer = Movie::where('resolution',5)->where('status', 1)->orderBy('ngaycapnhat','DESC')->take(5)->get();
        $category = Category::orderBy('position', 'ASC')->where('status', 1)->get(); 
        $country = Country::orderBy('id','DESC')->get();
        $genre = Genre::orderBy('id','DESC')->get();
        //đếm admin
        $category_total = Category::all()->count(); 
        $country_total = Country::all()->count();
        $genre_total = Genre::all()->count();
        $movie_total = Movie::all()->count();

        //tracking user activity
        // $total_users = DB::table('tracker_sessions')->count();
        // $total_users_week = DB::table('tracker_sessions')->where('created_at','<=', Carbon::now('Asia/Ho_Chi_Minh')->subDays(7))->count();
        // $total_users_month = DB::table('tracker_sessions')->where('created_at','<=', Carbon::now('Asia/Ho_Chi_Minh')->subMonth())->count();
        // $total_users_3months = DB::table('tracker_sessions')->where('created_at','<=', Carbon::now('Asia/Ho_Chi_Minh')->subMonths(3))->count();
        // $total_users_thisyear = DB::table('tracker_sessions')->where('created_at','<=', Carbon::now('Asia/Ho_Chi_Minh')->subYear())->count();

        View::share([

            //tracking user
            // 'total_users' => $total_users,
            // 'total_users_week' => $total_users_week,
            // 'total_users_month' => $total_users_month,
            // 'total_users_3months' => $total_users_3months,
            // 'total_users_thisyear'=>$total_users_thisyear,

            //đếm cho trang admin
            'category_total' => $category_total,
            'country_total' => $country_total,
            'genre_total' => $genre_total,
            'movie_total' => $movie_total,

            'info'=>$info,

            'category_home'=>$category,
            'genre_home'=>$genre,
            'country_home'=>$country,

            'phimhot_sidebar'=>$phimhot_sidebar,
            'phimhot_trailer'=>$phimhot_trailer,
        ]);
    }
}
