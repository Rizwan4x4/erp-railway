<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class EmailClass extends Mailable
{

    public function build()
    {
        return $this->subject('Subject of the Email')->view('auth.passwords.email'); // Create a Blade view file for your email content
    }
}
