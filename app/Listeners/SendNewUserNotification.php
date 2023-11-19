<?php

namespace App\Listeners;

use App\Events\NewContactRegistered;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class SendNewUserNotification implements ShouldQueue
{
    use InteractsWithQueue;

    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(NewContactRegistered $event): void
    {
        $emails = collect($event->contactGroup->contacts()->pluck('email')->toArray());
       $emails->each(function(string $email) use($emails) {
           Mail::send('emails.Notification', ['contactsCount' => count($emails)], function ($message) use ($email) {
               $message->to($email)->subject('Contacts Count');
           });
       });
    }
}
