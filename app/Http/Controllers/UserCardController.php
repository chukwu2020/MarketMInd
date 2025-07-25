<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class IDVerificationSubmitted extends Notification
{
    use Queueable;

    protected $user;

    public function __construct($user)
    {
        $this->user = $user;
    }

    public function via($notifiable)
    {
        return ['mail', 'database'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('New ID Verification Submitted')
            ->line('A user has submitted an ID verification request.')
            ->line('User: ' . $this->user->name . ' (' . $this->user->email . ')')
            ->action('Review Now', url('/admin/id-verifications')) // update this with your route
            ->line('Please review and approve or reject the verification.');
    }

    public function toDatabase($notifiable)
    {
        return [
            'title' => 'New ID Verification Submitted',
            'message' => 'User ' . $this->user->name . ' submitted ID verification.',
        ];
    }
}
