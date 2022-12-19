<?php

namespace App\Listeners;

use App\Events\TaskCreatedEvent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class TaskCreatedEventListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  TaskCreatedEvent  $event
     * @return void
     */
    public function handle(TaskCreatedEvent $event)
    {
        //
        // print_r($event);
    }
}
