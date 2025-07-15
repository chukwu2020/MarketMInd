<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class OtpPasswordResetMail extends Mailable
{
    use Queueable, SerializesModels;

    public $otp;
    public $userName;

    public function __construct($otp, $user)
    {
        $this->otp = $otp;
        $this->userName = $user->name ?? 'there';
    }

    public function build()
    {
        return $this->from(config('mail.from.address'), config('mail.from.name'))
                    ->subject('Your Password Reset Code')
                    ->view('auth.passwords.password_otp');
    }
}
