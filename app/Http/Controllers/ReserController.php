<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Promotion;

class ReserController extends Controller
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
         $promotion_type1 = Promotion::where('promotion_type_id', 1)->get();
         $promotion_type2 = Promotion::where('promotion_type_id', 2)->get();
         $promotion_type3 = Promotion::where('promotion_type_id', 3)->get();
         $promotion_type4 = Promotion::where('promotion_type_id', 4)->get();
         $promotion_type5 = Promotion::where('promotion_type_id', 5)->get();

         return view('promotion.reser', ['promotion_type1' => $promotion_type1,
                     'promotion_type2' => $promotion_type2,
                     'promotion_type3' => $promotion_type3,
                     'promotion_type4' => $promotion_type4,
                     'promotion_type5' => $promotion_type5,
                 ]);
    }
}
