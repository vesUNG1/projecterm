<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function sendMail($body,$receiver_email){
        $this->receiver_email = $receiver_email;
        Mail::raw($body, function ($message) {
            $message->from('sar.s@mail.com', 'แจ้งผลการอนุมัติ');
            $message->to($this->receiver_email)->subject('แจ้งผลการอนุมัติ');
        });
    }
}
