<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Food_menus;
use App\Food_type;
use App\User_type;
use BD;
use File;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Storage;
class FoodmenuController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function __construct()
    {

       $this->Food_menusModel = new Food_menus;
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
        $food_menus = $this->Food_menusModel->orderBy('id','desc')->get();
       // $name = DB::table('food_menu')->where('is_recommend', 1)->get();
      // return $test = Food_menus::where('food_type',1)->ger();
        return view('admin.foodmenu.all_foodmanu', ['food_menus' => $food_menus]);
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
            $food_type = Food_type::get();
            return view('admin.foodmenu.add_menu', ['food_type'=> $food_type]);
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
       if ($request->hasFile('file')) {
        $file = $request->file('file');
     $extension = $file->getClientOriginalExtension(); // you can also use file name
     $fileName = time().'.'.$extension;
     $path = public_path().'/storage/Food_menus';
     $uplaod = $file->move($path,$fileName);
     $arr = new Food_menus;
     $arr->image = $fileName;
     $arr->food_name = $request->food_name;
     $arr->is_recommend = $request->is_recommend;
     $arr->food_type = $request->food_type;
     $arr->price = $request->price;
     $arr->special_price = $request->special_price;
     $arr->big_price = $request->big_price;
     $arr->is_active = $request->is_active;
     $arr->save();
     if ($arr) {
         return redirect()->route('foodmenu.all_foodmanu');
     }else{
        return ["satus"=>false,"msg"=>"Can't save data"];
    }


}else{
    //return $request->all();
    $arr = new Food_menus;
    $arr->image = "noimage.png";
    $arr->food_name = $request->food_name;
    $arr->is_recommend = $request->is_recommend;
    $arr->food_type = $request->food_type;
    $arr->price = $request->price;
    $arr->special_price = $request->special_price;
    $arr->big_price = $request->big_price;
    $arr->is_active = $request->is_active;
    $arr->save();
    if ($arr) {
        return redirect()->route('foodmenu.all_foodmanu');
    }

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

        $edit_menu = Food_menus::where('id', $id)->first();
        $food_type = Food_type::get();
        return view('admin.foodmenu.edit_menu', ['edit_menu' => $edit_menu, 'food_type'=> $food_type]);
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

        //return $request->all();
        if ($id) {
           if ($request->hasFile('file')) {
            // $filename = $request->file->getClientOriginalName();
            // $request->file->storeAs('public/Food_menus',$filename);
            // $arr = new Food_menus;
            $file = $request->file('file');
     $extension = $file->getClientOriginalExtension(); // you can also use file name
     $fileName = time().'.'.$extension;
     $path = public_path().'/storage/Food_menus';
     $uplaod = $file->move($path,$fileName);
     $update_menu = Food_menus::where('id',$id)->first();
     $update_menu->image = $fileName;
     $update_menu->food_name = $request->food_name;
     $update_menu->is_recommend = $request->is_recommend;
     $update_menu->food_type = $request->food_type;
     $update_menu->price = $request->price;
     $update_menu->special_price = $request->special_price;
     $update_menu->big_price = $request->big_price;
     $update_menu->is_active = $request->is_active;
     $update_menu->save();
     if ($update_menu) {
         return redirect()->route('foodmenu.all_foodmanu');
     }else{
        return ["satus"=>false,"msg"=>"Can't update data"];
    }


}else{
    $update_menu = Food_menus::where('id',$id)->first();
    $update_menu->food_name = $request->food_name;
    $update_menu->food_type = $request->food_type;
    $update_menu->is_recommend = $request->is_recommend;
    $update_menu->price = $request->price;
    $update_menu->special_price = $request->special_price;
    $update_menu->big_price = $request->big_price;
    $update_menu->is_active = $request->is_active;
    $update_menu->save();
    if ($update_menu) {
        return redirect()->route('foodmenu.all_foodmanu');
    }

    return ["satus"=>false,"msg"=>"Can't update data"];
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
        $image = Food_menus::where('id',$id)->first();
        $file = $image->image;
        Storage::Delete('public/Food_menus/'.$file);
        $menu_delete = Food_menus::where('id',$id)->delete();
        if($menu_delete){
            return redirect()->route('foodmenu.all_foodmanu');

        }else{
            return ["satus"=>false,"msg"=>"Can't delete data"];
        }
    }
}
