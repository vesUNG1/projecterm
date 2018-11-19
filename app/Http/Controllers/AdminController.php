<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\User;
use App\User_type;
use App\Contact;
class AdminController extends Controller
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
			$user = User::paginate(15);
			return view('admin.home.index', ['user' => $user]);
			break;
			case '3':
			return redirect("/counter_staff");
			break;
			case '4':
			return redirect("/counter_staff");
			break;

		}


	}

	public function viweContact(){
		$contact = Contact::orderBy('id','desc')->get();
		return view('admin.home.contact', ['contact' => $contact]);
	}

	public function destroy($id)
	{

		$contact_delete = Contact::where('id',$id)->delete();
		if($contact_delete){
			session()->flash('contact_delete', 'ลบสำเร็จ');
			return redirect()->route('viewcontact');

		}else{
			return "error message..";
		}
	}


}
