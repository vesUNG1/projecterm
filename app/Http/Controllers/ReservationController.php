<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Dining_table;
use App\Food_type;
use App\Food_menus;
use App\Reservation;
use App\Order;
use App\Order_details;
use App\User;
use Illuminate\Support\Facades\Auth;

class ReservationController extends Controller
{

	public function __construct()
	{
		$this->middleware('auth');
	}
	public function index()
	{
       $user = Auth::user();
       $users_type_id = $user->user_type_id;
       switch ($users_type_id) {
        case '1':
        return view('home');
        break;
        case '2':
         $reservation = Reservation::orderBy('id','desc')->get();
        foreach ($reservation as $key => $value) {
            $reservation[$key]['dining_table'] = Dining_table::where('id',$value['dining_table_id'])->orderBy('id','desc')->get();
            $reservation[$key]['user'] = User::where('id',$value['user_id'])->orderBy('id','desc')->get();
        }
        //return $reservation;

        return view('admin.reservations.reservations',['reservation'=> $reservation]);
        break;
        case '3':
        return redirect("/counter_staff");
        break;
        case '4':
        return redirect("/chef");
        break;
        case '5':
        return redirect("/receptionist");
         case '6':
         return redirect("/serving");
        break;

    }

}
public function create(request $request)
{

}

public function search(Request $request, $id){

    return $table_name = Dining_table::where('id', $id)->first();

    $data = [
     'name' => $table_name,

 ];
 return $data;


}

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

      return $request->all();
  }

  public function destroy($id){
     $reservation_delete = Reservation::where('id',$id)->delete();
       if($reservation_delete){
        session()->flash('reservation_delete', 'ลบรายงานเรียบร้อยแล้ว');
           return redirect()->route('reservations.report_reservation');

       }else{
        return "error message..";
    }
  }


}
