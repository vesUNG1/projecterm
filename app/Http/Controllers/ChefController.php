<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Dining_table;
use App\Reservation;
use App\Order_details;
use App\Order;
use App\Food_menus;
use App\Promotion_type;
use App\Promotion;
class ChefController extends Controller
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
    return redirect("/");
    break;
    case '2':
    return redirect("/admin");
    break;
    case '3':
    return redirect("/counter_staff");
    break;
    case '4':
             // $current_date = strtotime(Date('Y-m-d H:i:s'));
      // $reserve_date = strtotime("20-08-2018 16:30");
      // $diffdate = round(abs($current_date - $reserve_date) / 60,2);
      // if($diffdate >= 10){
      //   echo "เปลี่ยนสถานะ";
      // }
      // return;
      // return $currenttime = $date." ".$time;
    $table = Dining_table::where('status',0)->get();
    foreach ($table as $key => $val) {
     $table[$key]['reservation'] = Reservation::where('dining_table_id',$val->id)->where('is_active',1)->get();
     foreach ($table[$key]['reservation'] as $key2 => $val2) {
         $reserve = $val2->reserve_date;
         $current_date = strtotime(Date('Y-m-d H:i'));
         $reserve_date = strtotime(Date($reserve));
         $diffdate = round(abs($current_date - $reserve_date) / 60,2);
         if($diffdate >= 10){
                    // $update_reservation = Reservation::where('dining_table_id',$val2->dining_table_id)->update(["is_active"=> 0]);
                    // $update_table = Dining_table::where('id', $val2->dining_table_id)->first();
                    // $update_table->status = 1;
                    // $update_table->color = "success";
                    // $update_table->save();

         }
         $table[$key]['reservation'][$key2]['order'] = Order::where('reservationld_id',$val2->id)->get();
         foreach ($table[$key]['reservation'][$key2]['order'] as $key3 => $val3) {
             $table[$key]['reservation'][$key2]['order'][$key3]['order_details'] = Order_details::where('order_id', $val3->id)->where('is_cook',0)->get();

             foreach ($table[$key]['reservation'][$key2]['order'][$key3]['order_details'] as $key4 => $val4) {
                $date = $val4['created_at'];
                $strYear = date("Y",strtotime($date))+543;
                $strMonth= date("n",strtotime($date));
                $strDay= date("j",strtotime($date));
                $strHour= date("H",strtotime($date));
                $strMinute= date("i",strtotime($date));
                $strSeconds= date("s",strtotime($date));
                $strMonthCut = Array("","ม.ค.","ก.พ.","มี.ค.","เม.ย.","พ.ค.","มิ.ย.","ก.ค.","ส.ค.","ก.ย.","ต.ค.","พ.ย.","ธ.ค.");
                $strMonthThai=$strMonthCut[$strMonth];
                $table[$key]['reservation'][$key2]['order'][$key3]['order_details'][$key4]['date'] = $strDay.' '.$strMonthThai.' '.$strYear.' '.$strHour.':'.$strMinute.' '.'น.';
                $table[$key]['reservation'][$key2]['order'][$key3]['order_details'][$key4]['food_details'] = Food_menus::where('id',$val4->food_id)->get();

                if ($val4->food_id == null) {
                   $table[$key]['reservation'][$key2]['order'][$key3]['order_details'][$key4]['promotion'] = Promotion::where('id',$val4->promotion_id)->get();
                }
            }
        }
    }
}
            //return $table;

return view('chef.chef',['table'=> $table]);
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
    public function store($id)
    {


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
        $update_is_cook = Order_details::where('id',$id)->update(['is_cook'=> 1]);
        if ($update_is_cook) {
            return redirect()->back();
        }

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
