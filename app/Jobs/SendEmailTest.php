<?php

namespace App\Jobs;

use App\Models\Guardian;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Mail;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Contracts\Queue\ShouldBeUnique;

class SendEmailTest implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    protected  $user;
    public function __construct($parent)
    {
        //
        // var_dump($parent);
        $this->user = $parent;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        // var_dump('test data'); die;
        //
        // Mail::to('nabnit.jha@sofossoftwares.com')->send(new \App\Mail\SendEmailTest());
        // Mail::send(new \App\Mail\SendEmailTest(), [], function ($message) {
        //     $message->from('us@example.com', 'Laravel');
        //     $message->to('nabnit.jha@sofossoftwares.com')->cc('bar@example.com');
        // });

        Mail::to($this->user)->send(new \App\Mail\SendEmailTest($this->user));
    }
}
