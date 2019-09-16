<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use NotificationChannels\Twilio\TwilioChannel;
use NotificationChannels\Twilio\TwilioSmsMessage;

class VerificationCode extends Notification
{
    use Queueable;

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return [TwilioChannel::class];

    }

    /**
     * Get the Twilio / SMS representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return TwilioSmsMessage
     */
    public function toTwilio($notifiable)
    {
        return (new TwilioSmsMessage)
            ->content("Your " . env('APP_NAME') . " account verification pin is {$notifiable->phone_otp}");
    }
}
