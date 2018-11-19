<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Shopatmosphere;
use Illuminate\Support\Facades\Auth;
class ImageController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //$this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
         $show_image = Shopatmosphere::orderBy('id','desc')->paginate(12);
        return view('image.image',['show_image'=>$show_image,]);
    }

   //   public function store(Request $request)
   //  {
   //      if ($request->hasFile('file')) {
   //       $filename = $request->file->getClientOriginalName();
   //       $request->file->storeAs('public/Shopatmosphere',$filename);
   //       $arr = new Shopatmosphere;
   //       $arr->image = $filename;
   //       $arr->save();
   //       if ($arr) {
   //           return redirect()->route('shopatmosphere.index');
   //       }else{
   //          return ["satus"=>false,"msg"=>"Can't save data"];
   //      }
   //   }
   // }
}
