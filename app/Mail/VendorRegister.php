<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class VendorRegister extends Mailable
{
    use Queueable, SerializesModels;

    private $vendor;

    public function __construct($vendor)
    {
        $this->vendor = $vendor;
    }

    public function build()
    {
        return $this->view('emails.vendor-register', [
            'vendor' => $this->vendor
        ]);
    }
}
