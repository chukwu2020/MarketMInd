<?php

namespace App\Notifications;

use App\Models\IdVerification;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Messages\BroadcastMessage;

class IDVerificationSubmitted extends Notification implements ShouldQueue
{
    use Queueable;

    public $verification;
    public $title;
    public $message;

    public function __construct(IdVerification $verification)
    {
        $this->verification = $verification;
        $this->title = 'ID Verification Submitted - MarketMind';
        $this->message = 'Your ID verification has been successfully submitted and is under review. You will be notified once it has been reviewed.';
    }

    public function via($notifiable)
    {
        // Check if user has email before sending mail notification
        $channels = ['database'];
        
        if ($notifiable->email) {
            $channels[] = 'mail';
        }
        
        return $channels;
    }

    public function toDatabase($notifiable)
    {
        return [
            'title' => $this->title,
            'message' => $this->message,
            'verification_id' => $this->verification->id,
            'action_url' => url('/dashboard/id_verification'),
            'created_at' => now()->toDateTimeString(),
        ];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject($this->title)
            ->greeting('Hello ' . $notifiable->name . ',')
            ->line($this->message)
            ->action('View Verification Status', url('/dashboard/id_verification'))
            ->line('Thank you for using MarketMind!')
            ->line('If you did not initiate this request, please contact our support team immediately.');
    }

    public function toBroadcast($notifiable)
    {
        return new BroadcastMessage([
            'title' => $this->title,
            'message' => $this->message,
            'verification_id' => $this->verification->id,
            'created_at' => now()->toDateTimeString(),
        ]);
    }
}