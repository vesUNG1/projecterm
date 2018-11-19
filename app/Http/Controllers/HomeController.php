<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\User;
use App\Food_menus;
use App\Food_type;
use Carbon\Carbon;
use App\Shopatmosphere;
use App\promotion;
class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
      // $this->middleware('auth');
       $this->Food_menusModel = new Food_menus;
   }



    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      $promotion = promotion::limit(4)->get();
       $food_is_recommend = Food_menus::where('is_recommend', 1)->select('food_name','image')->orderBy('id','desc')->get();
       $show_image = Shopatmosphere::orderBy('id','desc')->paginate(12);
       return view('home.index', ['food_is_recommend'=> $food_is_recommend,
        'show_image'=>$show_image,
        'promotion' => $promotion,
    ]);

   }
}
