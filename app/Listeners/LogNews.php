<?php

namespace App\Listeners;

use App\Events\NewsLogging;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use DB;

class LogNews
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
     * @param  \App\Events\NewsLogging  $event
     * @return void
     */
    public function handle(NewsLogging $event)
    {
        //
        $news = $event->action;
        DB::table('activity_log')->insert([
            'action' => $news['action'],
            'description' => $news['action'] . ': ' . $news['title'],
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
