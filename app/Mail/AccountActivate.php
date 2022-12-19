<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class AccountActivate extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    protected  $user;
    protected $dynamicPassword;
    protected $data;
    public function __construct($user,$dynamicPassword)
    {
        //
        $this->user = $user;
        $this->dynamicPassword = $dynamicPassword;
        // $this->data = [
        //     'user'  => $user,
        //     'dynamicPassword'   => $dynamicPassword
        // ];
        
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('emails.AccountActivate')->with(['user'=>$this->user,'dynamicPassword'=>$this->dynamicPassword]);
    }
}
