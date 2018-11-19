<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Dining_table;
use Illuminate\Support\Facades\Auth;

class ReceptionistController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
     public function __construct()
    {
        $this->middleware('auth');
    }


    public function index()
    {

    $users = Auth::user();
    $users_type_id = $users->user_type_id;
    $user = $users->name;
    switch ($users_type_id) {
      case '1':
      return redirect("/");
      break;
      case '2':
      return redirect("/admin");
      break;
      case '3':
        return request("/counter_staff");
      break;
      case '4':
      return redirect("/chef");
      break;
       case '5':
           //return view('receptionist.receptionist');
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
        return view('receptionist.receptionist',['table_status_a'=> $table_status_a,
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
      break;
       case '6':
      return redirect("/serving");
      break;

    }
  
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
}
