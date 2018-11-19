<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Carbon\Carbon;
use App\User_type;
use Illuminate\Support\Facades\Auth;
class AdduserController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Auth::user();
        $users_type_id = $user->user_type_id;
        switch ($users_type_id) {
            case '1':
            return redirect("/");
            break;
            case '2':
            $user_type = User_type::get();
            return view('admin.home.adduser', ['user_type' => $user_type]);
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
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(request $request)
    {

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

         $user_email = User::where('email', $request->email)->select('email')->first();
        if ($user_email) {
           session()->flash('email', 'อีเมล์นีลงทะเบียนแล้ว กรุณาใช้อีเมล์อื่น');
           return redirect()->route('home.adduser');
        }
        //return $request->all();
        if ($request->password != $request->password_confirmation) {
            session()->flash('password', 'รหัสไม่ตรงกัน');
           return redirect()->route('home.adduser');
        }
        $add_user = new User;
        $add_user->name = $request->name;
        $add_user->user_type_id = $request->users_type_id;
        $add_user->telephone_number = $request->telephone_number;
        $add_user->email = $request->email;
        $add_user->is_active = $request->is_active;
        $add_user->password = bcrypt($request->password);
        $add_user->save();
        if($add_user){
            session()->flash('notif', 'เพิ่มสำเร็จ');
          return redirect()->route('home.index');
      }else{

          return "error message..";
      }

      return $request->all();
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

        $edit_user = User::where('id', $id)->first();
        $user_type = User_type::get();
        return view('admin.home.edituser', ['edit_user' => $edit_user,
            'user_type' => $user_type
        ]);
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
        //return $request->is_active;
     if($id){
        if ($request->password) {
            $update_user = User::where('id',$id)->first();
            $update_user->name = $request->name;
            $update_user->email = $request->email;
            $update_user->telephone_number = $request->telephone_number;
            $update_user->password = bcrypt($request->password);
            $update_user->user_type_id = $request->users_type_id;
            $update_user->is_active = $request->is_active;
            $update_user->save();
            if($update_user){
               return redirect()->route('home.index');

           }else{
            return "error message..";
        }
    }else{
     $update_user = User::where('id',$id)->first();
     $update_user->name = $request->name;
     $update_user->email = $request->email;
     $update_user->telephone_number = $request->telephone_number;
     $update_user->user_type_id = $request->users_type_id;
     $update_user->is_active = $request->is_active;
     $update_user->save();
     if($update_user){
       return redirect()->route('home.index');

   }else{
    return "error message..";
}
}




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

        $user_delete = User::where('id',$id)->delete();
        if($user_delete){
           return redirect()->route('home.index');

       }else{
        return "error message..";
    }
}
}
