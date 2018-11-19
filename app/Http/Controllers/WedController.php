<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\User;

class WedController extends Controller
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
        // $user = Auth::user();
        // $users_type_id = $user->user_type_id;
        // switch ($users_type_id) {
        //     case '1':
        //     return view('home');
        //     break;
        //     case '2':
        //    return redirect("/admin");
        //     break;
        //     case '3':
        //     return redirect("/waitress");
        //     break;
        //     case '4':
        //     return redirect("/counter_staff");
        //     break;

        // }
        return view('wed.wed');
        
    }
}
