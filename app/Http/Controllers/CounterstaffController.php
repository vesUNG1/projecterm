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
use App\Helper;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Promotion_type;
use App\Promotion;
class CounterstaffController extends Controller
{

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
      $dining_table = Dining_table::paginate(6);
      $food_type = Food_type::get();
            //$food_menus = Food_menus::get();
      $food_type_vegetable = DB::table('food_menu')->where('food_type', 1)->get();

      return view('counter_staff.index',['dining_table'=> $dining_table,
        'user'=> $user,
        'food_type'=> $food_type,
        'food_type_vegetable'=> $food_type_vegetable,

      ]);
      break;
      case '4':
      return redirect("/chef");
      break;
      case '5':
      return redirect("/receptionist");
      case '6':
      return redirect("/serving");

    }

  }

  public function search(Request $request){

    if ($request->search) {
     $search = $request->search;
    $dining_table = Dining_table::where('name', 'LIKE', '%' . $search . '%')->paginate(6);
    $food_type = Food_type::get();
    $food_type_vegetable = DB::table('food_menu')->where('food_type', 1)->get();
    $users = Auth::user();
    $users_type_id = $users->user_type_id;
    $user = $users->name;
    return view('counter_staff.index',['dining_table'=> $dining_table,
      'user'=> $user,
      'food_type'=> $food_type,
      'food_type_vegetable'=> $food_type_vegetable
    ]);
    }else{
      return redirect("/counter_staff");
    }

  }

  public function store(Request $request)
  {
      //  return $request->all();

    $price = 0;
    $reserve_date = $request->reserve_date." ".$request->time;
    $dining_table_id = $request->dining_table_id;
    $users = Auth::user();
    $users_id = $users->id;
    $add_reservation = new Reservation;
    $add_reservation->dining_table_id = $dining_table_id;
    $add_reservation->user_id = $users_id;
    $add_reservation->reserve_date = $reserve_date;
    $add_reservation->reserve_mobile = $request->reserve_mobile;
    $add_reservation->save();
    $reservation_id = $add_reservation->id;
    if($add_reservation){
      $update_dining_table = Dining_table::where('id',$dining_table_id)->first();
      $update_dining_table->status = 0;
      $update_dining_table->color = 'danger';
      $update_dining_table->save();
      $dining_id = $update_dining_table->id;
      if ($update_dining_table) {
        return redirect()->route('counterstaff.index');
       // return redirect()->route('reservation_food',['id'=>$reservation_id]);
            // $users = Auth::user();
            // $users_type_id = $users->user_type_id;
            // $user = $users->name;
            // $dining_table = Dining_table::where('id', $dining_id)->first();
            // $food_type = Food_type::get();
            //  $food_type_vegetable = DB::table('food_menu')->where('food_type', 1)->get();
            // return view('counter_staff.reservation_food',['dining_table'=> $dining_table,
            //     'user'=> $user,
            //     'food_type'=> $food_type,
            //     'food_type_vegetable'=> $food_type_vegetable,
            //     'reservation_id'=> $reservation_id,
            // ]);

           //  if (!$request->image) {
           //      return redirect()->route('counterstaff.index');
           //  }
           //  foreach ( $request->price as $key => $value) {
           //      $price += $value;
           //  }
           //  $add_order = new Order;
           //  $add_order->reservationld_id = $reservation_id;
           //  $add_order->orde_date = $reserve_date;
           //  $add_order->is_paid = 0;
           //  $add_order->amount = $price;
           //  $add_order->save();
           //  $order_id = $add_order->id;
           //  if ($add_order) {
           //      foreach ($request->image as $key => $value) {
           //          $add_order_details = new Order_details;
           //          $add_order_details->order_Id = $order_id;
           //          $add_order_details->food_id = $value;
           //          $add_order_details->totalorder = 1;
           //          $add_order_details->is_cook = 0;
           //          $add_order_details->save();
           //      }
           //      if ($add_order_details) {
           //         return redirect()->route('counterstaff.index');
           //     }


           // }

     }else{
      return ["satus"=>false,"msg"=>"Can't save data"];
    }
  }else{
    return "error message..";
  }

}


public function reservation_report(Request $request, $id)
{
  $amount = 0;
  $table_name = Dining_table::where('id',$id)->first();
  $reservation = Reservation::where('dining_table_id', $id)->orderBy('id','desc')->first();
  $order = Order::where('reservationld_id', $reservation['id'])->first();
  $order_details = Order_details::where('order_Id',$order['id'] )->get();

  foreach ($order_details as $key => $order_detail) {
   $order_details[$key]['food_detail'] = Food_menus::where('id',$order_detail->food_id)->first();
   $amount += $order_detail['amount'];
   if ($order_detail->food_id == null) {
    $order_details[$key]['promotion'] = Promotion::where('id',$order_detail->promotion_id)->first();
    $date = $order_detail['created_at'];
    $strYear = date("Y",strtotime($date))+543;
    $strMonth= date("n",strtotime($date));
    $strDay= date("j",strtotime($date));
    $strHour= date("H",strtotime($date));
    $strMinute= date("i",strtotime($date));
    $strSeconds= date("s",strtotime($date));
    $strMonthCut = Array("","ม.ค.","ก.พ.","มี.ค.","เม.ย.","พ.ค.","มิ.ย.","ก.ค.","ส.ค.","ก.ย.","ต.ค.","พ.ย.","ธ.ค.");
    $strMonthThai=$strMonthCut[$strMonth];
    $order_details[$key]['datas'] = $strDay.' '.$strMonthThai.' '.$strYear.' '.$strHour.':'.$strMinute.' '.'น.';
  }
}

//return $order_details;
 $user_id =  $reservation['user_id'];
 $user = User::where('id', $user_id)->select('name')->first();
 $name = "qrcode";
if (!$user) {
  $user = ['name' =>$name];
}
$date = $reservation['reserve_date'];
$reserve_mobile = $reservation['reserve_mobile'];
$strYear = date("Y",strtotime($date))+543;
$strMonth= date("n",strtotime($date));
$strDay= date("j",strtotime($date));
$strHour= date("H",strtotime($date));
$strMinute= date("i",strtotime($date));
$strSeconds= date("s",strtotime($date));
$strMonthCut = Array("","ม.ค.","ก.พ.","มี.ค.","เม.ย.","พ.ค.","มิ.ย.","ก.ค.","ส.ค.","ก.ย.","ต.ค.","พ.ย.","ธ.ค.");
$strMonthThai=$strMonthCut[$strMonth];
$datas = $strDay.'&nbsp;'.$strMonthThai.'&nbsp;'.$strYear.'&nbsp;'.$strHour.':'.$strMinute.'&nbsp;'.'น.';

return view('counter_staff.reservation_report',['table_name'=> $table_name,
  'user'=> $user,
  'datas'=> $datas,
  'order'=> $order,
  'food'=>$order_details,
  'reserve_mobile'=>$reserve_mobile,
  'amount'=>$amount,

]);

}

// function formatDateThat($strDate)
// {
//     $strYear = date("Y",strtotime($strDate))+543;
//     $strMonth= date("n",strtotime($strDate));
//     $strDay= date("j",strtotime($strDate));
//     $strHour= date("H",strtotime($strDate));
//     $strMinute= date("i",strtotime($strDate));
//     $strSeconds= date("s",strtotime($strDate));
//     $strMonthCut = Array("","ม.ค.","ก.พ.","มี.ค.","เม.ย.","พ.ค.","มิ.ย.","ก.ค.","ส.ค.","ก.ย.","ต.ค.","พ.ย.","ธ.ค.");
//     $strMonthThai=$strMonthCut[$strMonth];
//     return "$strDay $strMonthThai $strYear $strHour:$strMinute";
// }


public function reservation_food(Request $request, $id)
{

  $reservation = Reservation::where('id', $id)->first();
  $users = Auth::user();
  $users_type_id = $users->user_type_id;
  $user = $users->name;
  $dining_table = Dining_table::where('id', $reservation['dining_table_id'])->first();
  $food_type = Food_type::get();
  $food_type_vegetable = DB::table('food_menu')->where('food_type', 1)->get();
  $food_boiled = DB::table('food_menu')->where('food_type', 2)->get();
  $f_m_fried = DB::table('food_menu')->where('food_type', 3)->get();
  $f_m_yum = DB::table('food_menu')->where('food_type',4 )->get();
  $f_m_dish = DB::table('food_menu')->where('food_type',5)->get();
  $f_m_piza = DB::table('food_menu')->where('food_type',6)->get();
  $f_m_beverage = DB::table('food_menu')->where('food_type',7)->get();
  $f_m_coffee = DB::table('food_menu')->where('food_type',8)->get();
  return view('counter_staff.reservation_food',['dining_table'=> $dining_table,
    'user'=> $user,
    'food_type'=> $food_type,
    'food_type_vegetable'=> $food_type_vegetable,
    'food_boiled'=> $food_boiled,
    'f_m_fried'=> $f_m_fried,
    'f_m_yum'=>$f_m_yum,
    'f_m_dish'=>$f_m_dish,
    'f_m_piza'=>$f_m_piza,
    'f_m_beverage'=>$f_m_beverage,
    'f_m_coffee'=>$f_m_coffee,
    'reservation_id'=> $reservation['id'],
    'reserve_date'=> $reservation['reserve_date'],
  ]);

}

public function order_food(Request $request){
  //return $request->all();
  $price = $request->price *  $request->totalorder;
  $order = Order::where('reservationld_id', $request->reservation_id)->first();
  if (!$order) {
   $add_order = new Order;
   $add_order->reservationld_id = $request->reservation_id;
   $add_order->orde_date = $request->orde_date;
   $add_order->is_paid = 0;
   // $add_order->amount = $price;
   $add_order->save();
   $order_id = $add_order->id;
   if ($add_order) {
    $add_order_details = new Order_details;
    $add_order_details->order_Id = $order_id;
    $add_order_details->food_id = $request->food_id;
    $add_order_details->totalorder = $request->totalorder;
    $add_order_details->amount = $price;
    $add_order_details->is_cook = 0;
    $add_order_details->save();
    if ($add_order_details) {
      session()->flash('add_order_details', $request->food_name);
      return redirect()->route('reservation_food',['id'=>$request->reservation_id]);
    }
  }


}else{
  $add_order_details = new Order_details;
  $add_order_details->order_Id = $order['id'];
  $add_order_details->food_id = $request->food_id;
  $add_order_details->totalorder = $request->totalorder;
  $add_order_details->amount = $price;
  $add_order_details->is_cook = 0;
  $add_order_details->save();
  if ($add_order_details) {
    session()->flash('add_order_details', $request->food_name);
    return redirect()->route('reservation_food',['id'=>$request->reservation_id]);
  }
}

}

public function confirm_payment(Request $request){
 // return $request->all();


  if ($request->order) {
   $update_order = Order::where('id', $request->order)->first();
   $update_order->is_paid = $request->is_paid;
   $update_order->save();
   if ($update_order) {
     $update_table = Dining_table::where('id', $request->table_id)->first();
     $update_table->status = 1;
     $update_table->color = "success";
     $update_table->save();
     if ($update_table) {
       $reservation = Reservation::where('dining_table_id',$request->table_id)->orderBy('id','desc')->first();
       if ($reservation) {
        $update_reservation = Reservation::where('id',$reservation->id)->update(['is_active'=> 0]);
        if ($update_reservation) {
          $Order = Order::where('reservationld_id',$reservation->id)->first();
          $Order_details = Order_details::where('order_id', $Order->id)->update(['is_cook'=> 3]);

          if ($Order_details) {
            session()->flash('update_table', 'ยืนยันสถานะสำเร็จ');
            return redirect()->route('counterstaff.index');
          }
        }

       }


    }else{
     return ["satus"=>false,"msg"=>"Can't update_table data"];
   }
 }
}else{
  $update_table = Dining_table::where('id', $request->table_id)->first();
  $update_table->status = 1;
  $update_table->color = "success";
  $update_table->save();
  if ($update_table) {
     $reservation = Reservation::where('dining_table_id',$request->table_id)->orderBy('id','desc')->first();
       if ($reservation) {
        $update_reservation = Reservation::where('id',$reservation->id)->update(['is_active'=> 0]);
         session()->flash('update_table', 'ยืยันสถานะสำเร็จ');
         return redirect()->route('counterstaff.index');
      }

 }else{
   return ["satus"=>false,"msg"=>"Can't update_table data"];
 }
}
}

public function new_reservation (){
  $reservation = Reservation::where('is_active',1)->orderBy('id','desc')->get();
  foreach ($reservation as $key => $value) {
    $reservation[$key]['dining_table'] = Dining_table::where('id',$value['dining_table_id'])->orderBy('id','desc')->get();
    $reservation[$key]['user'] = User::where('id',$value['user_id'])->orderBy('id','desc')->get();
  }
  return view('counter_staff.new_reservation',['reservation' => $reservation]);
}

public function confirm_reservation (Request $request){
  $update_reservation = Reservation::where('id',$request->reservations_id)->update(['is_active' => 0]);
  $update_table = Dining_table::where('id', $request->dining_tables_id)->first();
  $update_table->status = 1;
  $update_table->color = "success";
  $update_table->save();
  if ($update_table) {
   session()->flash('update_table', 'ยืยันสถานะสำเร็จ');
   return redirect()->route('counterstaff.new_reservation');
 }else{
   return ["satus"=>false,"msg"=>"Can't update_table data"];
 }
 return $request->all();
}


}
