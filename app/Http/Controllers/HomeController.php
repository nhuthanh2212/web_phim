<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Category;




class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $category = Category::orderBy('position','ASC')->get();
        $category_home = Category::with(['movie' => function($q){
            $q->withCount('episode')->where('status',1);
        }])->orderBy('position','ASC')->where('status',1)->get();
        return view('home',compact('category','category_home'));
       
    }
}
