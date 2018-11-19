<?php

namespace App\Http\Controllers;
use App\Contact;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
class ContactController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
       // $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
         
        return view('contact.contact');
    }

    public function contact(Request $request){
        $contact = new Contact;
        $contact->name = $request->name;
        $contact->email = $request->email;
        $contact->telephone_number = $request->telephone_number;
        $contact->contact = $request->contact;
        $contact->message = $request->message;
        $contact->save();
        if ($contact) {
           return redirect()->route('home');
        }

    }
}
