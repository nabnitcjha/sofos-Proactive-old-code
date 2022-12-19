<?php

namespace App\Http\Controllers\Forms;

use Twilio\Rest\Client;
use Illuminate\Http\Request;
use App\Models\UsersPhoneNumber;
use App\Http\Controllers\Controller;

class UsersPhoneNumberController extends Controller
{
    //

    public function sendMessage(Request $request)
    {
        // $account_sid = getenv("TWILIO_SID");
        // $auth_token = getenv("TWILIO_AUTH_TOKEN");
        // $twilio_number = getenv("TWILIO_NUMBER");

        // $account_sid = 'AC4eb65e33afa8a135d28286d1ac6a1bd0';
        // $auth_token = 'def23c22370981deac72eb48935bbcab';
        // $twilio_number = '+12282855321';

        $account_sid = 'AC6c41c7d519a4f13711292e360f540a88';
        $auth_token = '0f8edf8930f0090bb7e610cec42b7487';
        $twilio_number = '+12056565590';
        
        $client = new Client($account_sid, $auth_token);
        $client->messages->create($request->recipients,
                ['from' => $twilio_number, 'body' => $request->message] );
        return 'success';
    }
    public function receiveMessage(Request $request)
    {
        return $request;
    }
    public function storePhoneNumber(Request $request)
    {
        //run validation on data sent in
        $validatedData = $request->validate([
            'phone_number' => 'required|unique:users_phone_number|numeric'
        ]);
        $user_phone_number_model = new UsersPhoneNumber($request->all());
        $user_phone_number_model->save();
        return back()->with(['success' => "{$request->phone_number} registered"]);
    }
}
