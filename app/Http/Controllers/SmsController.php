<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Nexmo\Laravel\Facade\Nexmo;


class SmsController extends Controller
{
    public function sendSmsNotification(Request $request){
        Nexmo::message()->send([
            'to' => $request['contact_num'],
            'from' => '639083024328',
            'text' => "Your account in silingan application is now verified",
        ]);
    }
}
