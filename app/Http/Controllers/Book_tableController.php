<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Dining_table;
use Illuminate\Support\Facades\Auth;
use App\Reservation;
use App\Food_type;
use App\Food_menus;
use App\Order_details;
use App\Order;
use App\Promotion_type;
use App\Promotion;
use Illuminate\Support\Facades\DB;
class Book_tableController extends Controller
{
 public function __construct()
 {
  $this->middleware('auth');
}
public function index()
{
         //return $request->all();
  return $user = Auth::user();
  $users_type_id = $user->user_type_id;
  switch ($users_type_id) {
    case '1':
    return redirect("/");
    break;
    case '2':
    $user = User::paginate(15);
    return view('admin.home.index', ['user' => $user]);
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
      //return $request->all();
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
        return redirect()->route('book_food',['id'=>$reservation_id]);
      }
    }
  }
  public function book_food(Request $request, $id)
  {

   $reservation = Reservation::where('id', $id)->first();
   $users = Auth::user();
   $users_type_id = $users->user_type_id;
   $user = $users;
   $dining_table = Dining_table::where('id', $reservation['dining_table_id'])->first();
   $food_type = Food_type::get();
   $food_type_vegetable = DB::table('food_menu')->where('food_type', 1)->get();
   $f_m_boiled = DB::table('food_menu')->where('food_type', 2)->get();
   $f_m_fried = DB::table('food_menu')->where('food_type', 3)->get();
   $f_m_yum = DB::table('food_menu')->where('food_type',4 )->get();
   $f_m_dish = DB::table('food_menu')->where('food_type',5)->get();
   $f_m_piza = DB::table('food_menu')->where('food_type',6)->get();
   $f_m_beverage = DB::table('food_menu')->where('food_type',7)->get();
   $f_m_coffee = DB::table('food_menu')->where('food_type',8)->get();
   $f_m_soda = DB::table('food_menu')->where('food_type',9)->get();
   $f_m_spin = DB::table('food_menu')->where('food_type',10)->get();

   $amount = 0;
   $reservation = Reservation::where('user_id', $user->id)->orderBy('id','desc')->where('is_active',1)->first();
   $table_id= Dining_table::where('id', $reservation['dining_table_id'])->orderBy('id','desc')->first();
   $order = Order::where('reservationld_id', $reservation['id'])->first();

   $order_details = Order_details::where('order_Id',$order['id'] )->get();

   foreach ($order_details as $key => $order_detail) {

     $order_details[$key]['food_detail'] = Food_menus::where('id',$order_detail->food_id)->first();
     $amount += $order_detail['amount'];
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

  $promotion_type1 = Promotion::where('promotion_type_id', 1)->get();
  $promotion_type2 = Promotion::where('promotion_type_id', 2)->get();
  $promotion_type3 = Promotion::where('promotion_type_id', 3)->get();
  $promotion_type4 = Promotion::where('promotion_type_id', 4)->get();
  $promotion_type5 = Promotion::where('promotion_type_id', 5)->get();

  return view('status.bookfood',['dining_table'=> $dining_table,
    'user'=> $user,
    'food_type'=> $food_type,
    'food_type_vegetable'=> $food_type_vegetable,
    'f_m_boiled'=> $f_m_boiled,
    'f_m_fried'=> $f_m_fried,
    'f_m_yum'=>$f_m_yum,
    'f_m_dish'=>$f_m_dish,
    'f_m_piza'=>$f_m_piza,
    'f_m_beverage'=>$f_m_beverage,
    'f_m_coffee'=>$f_m_coffee,
    'f_m_soda'=>$f_m_soda,
    'f_m_spin'=>$f_m_spin,
    'reservation_id'=> $reservation['id'],
    'reserve_date'=> $reservation['reserve_date'],
    'order_details' => $order_details,
    // 'datas'=> $datas,
    'amount'=>$amount,
    'order' =>$order,
    'reservation' =>$reservation,
    'promotion_type1' => $promotion_type1,
    'promotion_type2' => $promotion_type2,
    'promotion_type3' => $promotion_type3,
    'promotion_type4' => $promotion_type4,
    'promotion_type5' => $promotion_type5,
  ]);

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
    public function destroy($id, $orders_amount, $amount)
    {

      $amount = $amount - $orders_amount;
      $order_details_delete = Order_details::where('id',$id )->delete();
      if($order_details_delete){
        session()->flash('order_details_delete', 'ยกเลิกสำเร็จ');
       // return redirect()->route('status.bookfood',['amount'=>$amount]);
        return redirect()->back();

      }else{
        return "error message..";
      }
    }

    public function order_food(Request $request){
     if ($request->price) {
       $price = $request->price *  $request->totalorder;
     }else if($request->special_price){
       $price = $request->special_price *  $request->totalorder;
     }else {
       $add_order = new Order;
       $price = $request->big_price *  $request->totalorder;
     }
     $order = Order::where('reservationld_id', $request->reservation_id)->first();
     if (!$order) {
      $add_order = new Order;
      $add_order->reservationld_id = $request->reservation_id;
      $add_order->orde_date = $request->orde_date;
      $add_order->is_paid = 0;
      $add_order->save();
      $order_id = $add_order->id;
      if ($add_order) {
       if ($request->promotion_type_id == "undefined") {
         $add_order_details = new Order_details;
         $add_order_details->order_Id = $order_id;
         $add_order_details->food_id = $request->food_id;
         $add_order_details->totalorder = $request->totalorder;
         $add_order_details->amount = $price;
         $add_order_details->is_cook = 0;
         $add_order_details->save();
         if ($add_order_details) {
          session()->flash('add_order_details', $request->food_name);
          return redirect()->route('book_food',['id'=>$request->reservation_id]);
        }
      }else{
        $add_order_details = new Order_details;
        $add_order_details->order_Id = $order_id;
        $add_order_details->promotion_id = $request->food_id;
        $add_order_details->totalorder = $request->totalorder;
        $add_order_details->amount = $price;
        $add_order_details->is_cook = 0;
        $add_order_details->save();
        if ($add_order_details) {
          session()->flash('add_order_details', $request->food_name);
          return redirect()->route('book_food',['id'=>$request->reservation_id]);
        }
      }
    }

  }else{
    if ($request->promotion_type_id == "undefined") {
      $add_order_details = new Order_details;
      $add_order_details->order_Id = $order['id'];
      $add_order_details->food_id = $request->food_id;
      $add_order_details->totalorder = $request->totalorder;
      $add_order_details->amount = $price;
      $add_order_details->is_cook = 0;
      $add_order_details->save();
      if ($add_order_details) {
        session()->flash('add_order_details', $request->food_name);
        return redirect()->route('book_food',['id'=>$request->reservation_id]);
      }
    }else{
      $add_order_details = new Order_details;
      $add_order_details->order_Id = $order['id'];
      $add_order_details->promotion_id = $request->food_id;
      $add_order_details->totalorder = $request->totalorder;
      $add_order_details->amount = $price;
      $add_order_details->is_cook = 0;
      $add_order_details->save();
      if ($add_order_details) {
        session()->flash('add_order_details', $request->food_name);
        return redirect()->route('book_food',['id'=>$request->reservation_id]);
      }
    }
  }

}

public function customer_report($id){

  $amount = 0;
  $reservation = Reservation::where('user_id', $id)->orderBy('id','desc')->where('is_active',1)->first();
  $table_id= Dining_table::where('id', $reservation['dining_table_id'])->orderBy('id','desc')->first();
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
 $date = $reservation['reserve_date'];
 $strYear = date("Y",strtotime($date))+543;
 $strMonth= date("n",strtotime($date));
 $strDay= date("j",strtotime($date));
 $strHour= date("H",strtotime($date));
 $strMinute= date("i",strtotime($date));
 $strSeconds= date("s",strtotime($date));
 $strMonthCut = Array("","ม.ค.","ก.พ.","มี.ค.","เม.ย.","พ.ค.","มิ.ย.","ก.ค.","ส.ค.","ก.ย.","ต.ค.","พ.ย.","ธ.ค.");
 $strMonthThai=$strMonthCut[$strMonth];
 $datas = $strDay.'&nbsp;'.$strMonthThai.'&nbsp;'.$strYear.'&nbsp;'.$strHour.':'.$strMinute.'&nbsp;'.'น.';

 if ($reservation == '' || $order == '') {

  if ($reservation) {
   session()->flash('reservation','ไม่มีรายการ');
   return redirect()->route('book_food',['id'=>$reservation['id']]);
 }
 session()->flash('reservation','ไม่มีรายการ');
 return redirect("/");

}

//return $order_details;
return view('status.customer_report',['order_details' => $order_details,
  'datas'=> $datas,
  'amount'=>$amount,
  'order' =>$order,
  'reservation' =>$reservation
]);

}
}
