<?php

// app/Notifications/TransactionNotification.php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Messages\BroadcastMessage;

class TransactionNotification extends Notification
{
    use Queueable;

    public $title;
    public $message;

    public function __construct($title, $message)
    {
        $this->title = $title;
        $this->message = $message;
    }

    public function via($notifiable)
    {
     
    return ['mail', 'database']; // ✅ This sends both email and in-app notification
}



    public function toDatabase($notifiable)
    {
        return [
            'title' => $this->title,
            'message' => $this->message,
        ];
    }

    // Optional email
   public function toMail($notifiable)
{
    return (new \Illuminate\Notifications\Messages\MailMessage)
        ->subject($this->title)
        ->view('dashboard.user.notifications', [
            'userName' => $notifiable->name,
            'subject' => $this->title,
            'messageBody' => $this->message,
         
        ]);
}


    // Optional for real-time broadcast (if using pusher/echo)
    public function toBroadcast($notifiable)
    {
        return new BroadcastMessage([
            'title' => $this->title,
            'message' => $this->message,
        ]);
    }
}
