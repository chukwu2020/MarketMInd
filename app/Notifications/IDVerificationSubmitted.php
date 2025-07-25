<?php

namespace App\Notifications;

use App\Models\IDVerification;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Messages\BroadcastMessage;

class IDVerificationSubmitted extends Notification
{
    use Queueable;

    public $verification;
    public $title;
    public $message;

    public function __construct(IDVerification $verification)
    {
        $this->verification = $verification;
        $this->title = 'ID Verification Submitted - MarketMind';
        $this->message = 'Your ID verification has been successfully submitted and is under review. You will be notified once it has been reviewed.';
    }

    public function via($notifiable)
    {
        return ['mail', 'database']; // Email + in-app notification
    }

    public function toDatabase($notifiable)
    {
        return [
            'title' => $this->title,
            'message' => $this->message,
        ];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
    ->subject($this->title)
    ->greeting('Hello ' . $notifiable->name . ',')
    ->line($this->message)
    ->action('View Verification Status', url('/dashboard/id_verification'))
    ->line('Thank you for using MarketMind!');

    }

    public function toBroadcast($notifiable)
    {
        return new BroadcastMessage([
            'title' => $this->title,
            'message' => $this->message,
        ]);
    }
}
