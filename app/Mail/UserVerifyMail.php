<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class UserVerifyMail extends Mailable
{
    use Queueable, SerializesModels;

    public $verificationCode;
    public $url;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($verificationCode, $url)
    {
        $this->verificationCode = $verificationCode;
        $this->url = $url;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Nutrition Calculator - Verify your e-mail address')
                    ->view('emails.verify-email');
    }
}
