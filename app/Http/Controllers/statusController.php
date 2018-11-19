<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Dining_table;
use Illuminate\Support\Facades\Auth;

class StatusController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
       //$this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

       // return $table_status = Dining_table::get();
        //โต๊ะ1-12
        $table_status_a = Dining_table::where('id','<=', 12)->get();
        //โต๊ะ20-22
        $table_status_b = Dining_table::where('id','=',13)->get();
        $table_status_c = Dining_table::where('id','=',14)->get();
        $table_status_d = Dining_table::where('id','=',15)->get();
        $table_status_e = Dining_table::where('id','=',16)->get();
        $table_status_f = Dining_table::where('id','=',17)->get();
        $table_status_g = Dining_table::where('id','=',18)->get();
        $table_status_h = Dining_table::where('id','=',19)->get();
        $table_status_i = Dining_table::where('id','=',20)->get();
        $table_status_k = Dining_table::where('id','>=',21)->get();
        return view('status.status',['table_status_a'=> $table_status_a,
                                    'table_status_b'=> $table_status_b,
                                    'table_status_c'=> $table_status_c,
                                    'table_status_d'=> $table_status_d,
                                    'table_status_e'=> $table_status_e,
                                    'table_status_f'=> $table_status_f,
                                    'table_status_g'=> $table_status_g,
                                    'table_status_h'=> $table_status_h,
                                    'table_status_i'=> $table_status_i,
                                    'table_status_k'=> $table_status_k,

    ]);

    }

}
