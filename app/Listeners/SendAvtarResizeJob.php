<?php

namespace App\Listeners;

use App\Events\UploadAvatar;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Jobs\ProcessAvatarResize;

class SendAvtarResizeJob
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
     * @param  \App\Events\UploadAvatar  $event
     * @return void
     */
    public function handle(UploadAvatar $event)
    {
        ProcessAvatarResize::dispatch($event->avatar, config('avatar.sizes'));
    }
}
