<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Mail;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Contracts\Queue\ShouldBeUnique;

class AccountActivate implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    protected  $user;
    protected $dynamicPassword;
    public function __construct($user,$dynamicPassword)
    {
        //
        // var_dump($user);
        
        $this->user = $user;
        $this->dynamicPassword = $dynamicPassword;
    }


    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        //
        // dd($this->dynamicPassword);
        Mail::to($this->user)->send(new \App\Mail\AccountActivate($this->user,$this->dynamicPassword));
    }
}
