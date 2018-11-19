<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Shopatmosphere;
use Illuminate\Support\Facades\Auth;
class ShopatmosphereController extends Controller
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
        $show_image = Shopatmosphere::orderBy('id','desc')->paginate(12);
        return view('admin.shopatmosphere.index', ['show_image' => $show_image]);
        break;
        case '3':
        return redirect("/counter_staff");
        break;
        case '4':
        return redirect("/chef");
        break;
        case '5':
        return redirect("/receptionist");
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
        if ($request->hasFile('file')) {
         // $filename = $request->file->getClientOriginalName();
         // $request->file->storeAs('public/Shopatmosphere',$filename);
            $file = $request->file('file');
            $extension = $file->getClientOriginalExtension(); // you can also use file name
            $fileName = time().'.'.$extension;
            $path = public_path().'/storage/Shopatmosphere';
            $uplaod = $file->move($path,$fileName);
            $arr = new Shopatmosphere;
            $arr->image = $fileName;
            $arr->save();
            if ($arr) {
               return redirect()->route('shopatmosphere.index');
           }else{
            return ["satus"=>false,"msg"=>"Can't save data"];
        }
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
