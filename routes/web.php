<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\IndexController;
use App\Http\Controllers\HomeController;
// admin controler
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CountryController;
use App\Http\Controllers\MovieController;
use App\Http\Controllers\GenreController;
use App\Http\Controllers\EpisodeController;
use App\Http\Controllers\InfoController;
use App\Http\Controllers\LinkMovieController;
use App\Http\Controllers\LoginGoogleController;
use App\Http\Controllers\LoginFBController;
use App\Http\Controllers\LeechMovieController;
use App\Http\Controllers\UserController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [IndexController::class, 'index'])->name('homepage');
Route::get('/danh-muc/{slug}', [IndexController::class, 'category'])->name('category');
Route::get('/the-loai/{slug}', [IndexController::class, 'genre'])->name('genre');
Route::get('/quoc-gia/{slug}', [IndexController::class, 'country'])->name('country');
Route::get('/phim/{slug}', [IndexController::class, 'movie'])->name('movie');

Route::get('/xem-phim/{slug}/{tap}/{server_active}', [IndexController::class, 'watch']);

Route::get('/so-tap', [IndexController::class, 'episode'])->name('so-tap');
Route::get('/nam/{year}', [IndexController::class, 'year']);
Route::get('/tag/{tag}', [IndexController::class, 'tag']);

Route::get('/tim-kiem', [IndexController::class, 'timkiem'])->name('tim-kiem');

Route::get('/loc-phim', [IndexController::class, 'loc_phim'])->name('loc-phim');

Route::POST('/add-rating', [IndexController::class, 'add_rating'])->name('add-rating');


Auth::routes();
// Auth::routes(['register'=>false,
// 	'reset'=>false,
// 	'verify'=>false,

// ]);


// //route admin

Route::group(['middleware' => ['auth','role:Admin']], function () {
    
    Route::resource('category', CategoryController::class);
    Route::resource('genre', GenreController::class);
    Route::resource('country', CountryController::class);
    Route::resource('linkmovie', LinkMovieController::class);
    Route::resource('episode', EpisodeController::class);
    Route::resource('movie',MovieController::class);
    Route::resource('info', InfoController::class);
    Route::resource('user',UserController::class);
    Route::get('phan-vai-tro/{id}',[UserController::class,'phan_vai_tro'])->name('phan-vai_tro');
    Route::post('insert-roles/{id}', [UserController::class,'insert_roles']);
    Route::get('phan-quyen/{id}',[UserController::class,'phan_quyen'])->name('phan-quyen');
    Route::post('insert-permission/{id}', [UserController::class,'insert_permission']);
    Route::post('insert-per', [UserController::class,'insert_per']);
     
    
    
});

//chuyển quyền nhanh
Route::get('impersonate/user/{id}',[UserController::class,'impersonate']);

Route::group(['middleware' => ['auth']], function () {
    Route::get('/home', [HomeController::class, 'index'])->name('home');
});

//sắp xếp
Route::post('resorting-category', [CategoryController::class,'resorting_category'])->name('resorting-category');

Route::post('resorting-genre', [GenreController::class,'resorting_genre'])->name('resorting-genre');

Route::post('resorting-country', [CountryController::class,'resorting_country'])->name('resorting-country');

Route::post('resorting-linkmovie', [LinkMovieController::class,'resorting_linkmovie'])->name('resorting-linkmovie');

Route::post('resorting-navbar', [MovieController::class,'resorting_navbar'])->name('resorting-navbar');

Route::post('resorting-movie', [MovieController::class,'resorting_movie'])->name('resorting-movie');

Route::get('sort-movie', [MovieController::class,'sort_movie'])->name('sort-movie');


//them tap phim
Route::get('add-episode/{id}', [EpisodeController::class,'add_episode'])->name('add-episode');

Route::get('select-episode', [EpisodeController::class,'select_episode'])->name('select-episode');



Route::GET('/update-year-phim', [MovieController::class, 'update_year']);

Route::GET('/update-topview-phim', [MovieController::class, 'update_topview']);

Route::post('/filter-topview-phim', [MovieController::class, 'filter_topview']);

Route::get('/filter-topview-default', [MovieController::class, 'filter_default']);

Route::GET('/update-season-phim', [MovieController::class, 'update_season']);



//thông tin website

Route::post('resorting-info', [InfoController::class,'resorting_info'])->name('resorting-info');

//thay đổi dữ liệu movie bằng ajax

Route::GET('/category-choose', [MovieController::class, 'category_choose'])->name('category-choose');

Route::GET('/country-choose', [MovieController::class, 'country_choose'])->name('country-choose');

Route::GET('/phimhot-choose', [MovieController::class, 'phimhot_choose'])->name('phimhot-choose');

Route::GET('/phude-choose', [MovieController::class, 'phude_choose'])->name('phude-choose');

Route::GET('/trangthai-choose', [MovieController::class, 'trangthai_choose'])->name('trangthai-choose');

Route::GET('/thuocphim-choose', [MovieController::class, 'thuocphim_choose'])->name('thuocphim-choose');

Route::GET('/dinhdang-choose', [MovieController::class, 'dinhdang_choose'])->name('dinhdang-choose');

Route::POST('/update-image-movie-ajax', [MovieController::class, 'update_image_movie_ajax'])->name('update-image-movie-ajax');

Route::get('/create_sitemap', function(){
	return Artisan::call('sitemap:create');
});

Route::POST('/watch-video', [MovieController::class, 'watch_video'])->name('watch-video');

//login account google
Route::get('auth/google', [LoginGoogleController::class, 'redirectToGoogle'])->name('login-by-google');
Route::get('auth/google/callback', [LoginGoogleController::class, 'handleGoogleCallback']);
//logout 
Route::get('logout-home', [LoginGoogleController::class, 'logout_home'])->name('logout-home');

//login facebook
Route::get('auth/facebook', [LoginFBController::class, 'redirectToFacebook'])->name('login-by-facebook');
Route::get('auth/facebook/callback', [LoginFBController::class, 'handleFacebookCallback']);

//route leech movie
Route::GET('leech-movie', [LeechMovieController::class, 'leech_movie'])->name('leech-movie');
Route::GET('leech-detail/{slug}', [LeechMovieController::class, 'leech_detail'])->name('leech-detail');

Route::post('leech-store/{slug}', [LeechMovieController::class, 'leech_store'])->name('leech-store');

Route::get('leech-episodes/{slug}', [LeechMovieController::class, 'leech_episodes'])->name('leech-episodes');

Route::post('leech-episode-store/{slug}', [LeechMovieController::class, 'leech_episode_store'])->name('leech-episode-store');


//phan quyen user

// Route::get('/impersonate/user/{id}',[UserController::class, 'impersonate']);
// Route::get('/user/stopImpersonate',[UserController::class,'stopImpersonate']);