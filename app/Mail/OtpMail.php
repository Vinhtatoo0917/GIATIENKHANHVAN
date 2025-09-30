<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class OtpMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public string $otp,
        public int $expiresMinutes = 5,
        public string $brandName = 'Gia Tiên Khánh Vân',
        public ?string $supportEmail = null,
    ) {}

    public function build()
    {
        return $this->subject('Mã xác nhận OTP')
            ->view('emails.otp')
            ->with([
                'otp'            => $this->otp,
                'expiresMinutes' => $this->expiresMinutes,
                'brandName'      => $this->brandName,
                'supportEmail'   => $this->supportEmail,
            ]);
    }
}
