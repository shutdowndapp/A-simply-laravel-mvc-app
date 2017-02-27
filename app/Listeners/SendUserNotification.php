<?php

namespace App\Listeners;

use App\Events\QuoteCreated;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Mail;

class SendUserNotification
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
     * @param  QuoteCreated  $event
     * @return void
     */
    public function handle(QuoteCreated $event)
    {
        $author = $event->author_name;
        $email = $event->author_email;

        Mail::send('email.user_notification',['name' => $author],function($m) use($author,$email) {
            $m->from('test@520world.com','test');
            $m->to($email,$author)->cc('massjt@qq.com');
            $m->subject('Thank you for your  Quotes');
        });
    }
}
