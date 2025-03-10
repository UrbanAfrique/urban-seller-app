<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class VendorOrder extends Mailable
{
    use Queueable, SerializesModels;

    private $vendor;
    private $items;
    private $link;

    public function __construct($vendor, $items, $link)
    {
        $this->vendor = $vendor;
        $this->items  = $items;
        $this->link  = $link;
    }

    public function build()
    {
        return $this->view('emails.vendor-order', [
            'vendor' => $this->vendor, 
            'items'  => $this->items,
            'link'  => $this->link,
        ]);
    }
}
