<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Food_menus;
use BD;
class FoodController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
       // $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
       // return $food_type = DB::table('food_menu')->where('food_type', 1)->get();
        $food_type0 = Food_menus::where('food_type', 0)->get();
         $food_image0 = Food_menus::where('food_type', 0)->select('image')->limit(10)->get();
         $food_type1 = Food_menus::where('food_type', 1)->get();
         $food_image1 = Food_menus::where('food_type', 1)->select('image')->limit(6)->get();
         $food_type2 = Food_menus::where('food_type', 2)->get();
         $food_image2 = Food_menus::where('food_type', 2)->select('image')->limit(4)->get();
         $food_type3 = Food_menus::where('food_type', 3)->get();
         $food_image3 = Food_menus::where('food_type', 3)->select('image')->limit(6)->get();
         $food_type4 = Food_menus::where('food_type', 4)->get();
         $food_image4 = Food_menus::where('food_type', 4)->select('image')->limit(8)->get();
         $food_type5 = Food_menus::where('food_type', 5)->get();
         $food_image5 = Food_menus::where('food_type', 5)->select('image')->limit(10)->get();
         $food_type6 = Food_menus::where('food_type', 6)->get();
         $food_image6 = Food_menus::where('food_type', 6)->select('image')->limit(4)->get();
         $food_type7 = Food_menus::where('food_type', 7)->get();
         $food_image7 = Food_menus::where('food_type', 7)->select('image')->limit(4)->get();
         $food_type8 = Food_menus::where('food_type', 8)->get();
         $food_image8 = Food_menus::where('food_type', 8)->select('image')->limit(2)->get();
         $food_type9 = Food_menus::where('food_type', 9)->get();
         $food_image9 = Food_menus::where('food_type', 9)->select('image')->limit(2)->get();
         $food_type0= Food_menus::where('is_recommend', 1)->get();
         $food_image0 = Food_menus::where('is_recommend', 1)->select('image')->limit(6)->get();
         $food_type10 = Food_menus::where('food_type', 10)->get();
         $food_image10 = Food_menus::where('food_type', 10)->select('image')->limit(2)->get();
        return view('foodmenu.food', ['food_type0' => $food_type0,
                                        'food_image0' => $food_image0,
                                        'food_type1' => $food_type1,
                                        'food_image1' => $food_image1,
                                        'food_type2' => $food_type2,
                                        'food_image2' => $food_image2,
                                        'food_type3' => $food_type3,
                                        'food_image3' => $food_image3,
                                        'food_type4' => $food_type4,
                                        'food_image4' => $food_image4,
                                        'food_type5' => $food_type5,
                                        'food_image5' => $food_image5,
                                        'food_type6' => $food_type6,
                                        'food_image6' => $food_image6,
                                        'food_type7' => $food_type7,
                                        'food_image7' => $food_image7,
                                        'food_type8' => $food_type8,
                                        'food_image8' => $food_image8,
                                        'food_type9' => $food_type9,
                                        'food_image9' => $food_image9,
                                        'food_type0' => $food_type0,
                                        'food_image0' => $food_image0,
                                        'food_type10' => $food_type10,
                                        'food_image10' => $food_image10,
         ]);
    }
}
