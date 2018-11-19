<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Dining_table;
use Illuminate\Support\Facades\Auth;
use Endroid\QrCode\ErrorCorrectionLevel;
use Endroid\QrCode\LabelAlignment;
use Endroid\QrCode\QrCode;
use Endroid\QrCode\Response\QrCodeResponse;
class DiningtableController extends Controller
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
      $user = Auth::user();
      $users_type_id = $user->user_type_id;
      switch ($users_type_id) {
        case '1':
        return view('home');
        break;
        case '2':
        $dining_table = Dining_table::paginate(8);
        return view('admin.diningtable.dining_table',['dining_table'=> $dining_table]);
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
      $user = Auth::user();
      $users_type_id = $user->user_type_id;
      switch ($users_type_id) {
        case '1':
        return view('home');
        break;
        case '2':
        return view('admin.diningtable.add_dining_table');
        break;
        case '3':
        return redirect("/counter_staff");
        break;
        case '4':
        return redirect("/counter_staff");
        break;

      }

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
      $chars = array(0,1,2,3,4,5,6,7,8,9,'A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z');
      $serial = '';
      $max = count($chars)-1;
      for($i=0;$i<20;$i++){
        $serial .= (!($i % 5) && $i ? '-' : '').$chars[rand(0, $max)];
      }
      $qrcode = $serial;
      if ($request->status == 1) {
       $color = "success";
     }else{
       $color = "danger";
     }


   // Create a basic QR code
     $host_url = "http://www.torpentorcafe.com";
     $qrCode = new QrCode($host_url."/QrCode/".$qrcode);
     $qrCode->setSize(300);
// Save it to a file
     $qrCode->writeFile("./storage/QRcode/qr-".$qrcode.".png");
     $arr = new Dining_table;
     $arr->name = $request->name;
   $arr->qrimage = "qr-".$qrcode.".png"; //$filename;
   $arr->seating = $request->seating;
   $arr->status = $request->status;
   $arr->qrcode = $qrcode;
   $arr->color = $color;
   $arr->save();
   if ($arr) {
     return redirect()->route('diningtable.dining_table');
   }else{
    return ["satus"=>false,"msg"=>"Can't save data"];
  }

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


     $dining_table = Dining_table::where('id', $id)->first();
     return view('admin.diningtable.edit_dining_table', ['dining_table' => $dining_table]);
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
      $chars = array(0,1,2,3,4,5,6,7,8,9,'A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z');
      $serial = '';
      $max = count($chars)-1;
      for($i=0;$i<20;$i++){
        $serial .= (!($i % 5) && $i ? '-' : '').$chars[rand(0, $max)];
      }
      $qrcode = $serial;
      if ($request->status == 1) {
       $color = "success";
     }else{
       $color = "danger";
     }
     $host_url = "http://www.torpentorcafe.com";
     $qrCode = new QrCode($host_url."/QrCode/".$qrcode);
     $qrCode->setSize(300);
// Save it to a file
     $qrCode->writeFile("./storage/QRcode/qr-".$qrcode.".png");

     $update = Dining_table::where('id',$id)->first();
     $update->name = $request->name;
     $update->seating = $request->seating;
     $update->qrimage = "qr-".$qrcode.".png";
     $update->status = $request->status;
     $update->qrcode = $qrcode;
     $update->color = $color;
     $update->save();
     if ($update) {
       return redirect()->route('diningtable.dining_table');
     }else{
      return ["satus"=>false,"msg"=>"Can't save data"];
    }

  }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
      $dining_table_delete = Dining_table::where('id',$id)->delete();
      if($dining_table_delete){
        return redirect()->route('diningtable.dining_table');

      }else{
        return ["satus"=>false,"msg"=>"Can't delete data"];
      }
    }
  }
