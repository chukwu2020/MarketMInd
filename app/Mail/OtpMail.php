<?php
namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class OtpMail extends Mailable
{
    use Queueable, SerializesModels;

    public $otp;
    public $verificationUrl;

    public function __construct($otp, $verificationUrl)
    {
        $this->otp = $otp;
        $this->verificationUrl = $verificationUrl;
    }

    public function build()
    {
        return $this->subject('Your OTP Verification Code')
                    ->view('emails.otp')
                    ->with([
                        'otp' => $this->otp,
                        'verificationUrl' => $this->verificationUrl,
                    ]);
    }
}
