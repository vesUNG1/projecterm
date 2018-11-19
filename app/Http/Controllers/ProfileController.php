<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\User;
class ProfileController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
     $this->middleware('auth');

   }



    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {
     $user = User::where('id', $id)->first();

     return view('profile.profile',['user'=>$user]);


   }

   public function update(Request $request)
   {
    if ($request->telephone_number) {
      $update_user = User::where('id',$request->id)->first();
      $update_user->name = $request->name;
      $update_user->email = $request->email;
      $update_user->telephone_number = $request->telephone_number;
      $update_user->save();
      if($update_user){
       session()->flash('password', 'แก้ไข สำเร็จ');
       return redirect()->back();

     }else{
      return "error message..";
    }
  }
  $update_user = User::where('id',$request->id)->first();
  $update_user->name = $request->name;
  $update_user->email = $request->email;
  $update_user->save();
  if($update_user){
   session()->flash('password', 'แก้ไข สำเร็จ');
   return redirect()->back();

 }else{
  return "error message..";
}

}

public function editpassword(Request $request)
{
  if ($request->password != $request->password_confirmation) {
   session()->flash('password_confirmation', 'รหัสไม่ตรงกัน');
   return redirect()->back();
 }else{
  $update_user = User::where('id',$request->id)->first();
  $update_user->password = bcrypt($request->password);
  $update_user->save();
  if($update_user){
    session()->flash('password', 'แก้ไข สำเร็จ');
    return redirect()->back();

  }else{
    return "error message..";
  }
}

}
}
