<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class OfferLetterMail extends Mailable
{
    use Queueable, SerializesModels;

    public $offer;

    /**
     * Create a new message instance.
     */
    public function __construct($offer)
    {
        $this->offer = $offer;
    }

    /**
     * Build the message.
     */
    public function build()
    {
        return $this->subject('Job Offer from ' . ($this->offer['company_name'] ?? 'Our Company'))
                    ->view('emails.offer_letter')
                    ->with([
                        'offer' => $this->offer
                    ]);
    }
}
