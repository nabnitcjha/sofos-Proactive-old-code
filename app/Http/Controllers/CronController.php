<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CronController extends Controller
{
    //
    public function classReminderEmail(Request $request)
    {
        $user = User::where('id', 10)->first();
        $dynamicPassword = Str::random($length = 10);
        // dispatch(new \App\Jobs\AccountActivate($user,$dynamicPassword)); 
        return array(
            "status"  => "200",
            "message" => 'Success'
        );
    }
}
