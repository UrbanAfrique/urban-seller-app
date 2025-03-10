<?php

namespace App\Mail;

use App\Enum\ApprovedStatusEnum;
use App\Enum\VendorStatusEnum;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class VendorApproval extends Mailable
{
    use Queueable, SerializesModels;

    private $loginUlr, $type, $mailHeading, $mailDescription;

    public function __construct($type, $loginUlr,$rejectionReason = "")
    {
        $this->type = $type;
        $this->mailHeading = $type == ApprovedStatusEnum::APPROVED ? 'Vendor Approved' : 'Vendor Rejected';
        if ($type == ApprovedStatusEnum::APPROVED) {
            $this->mailDescription = "Your Account has been Approved Successfully";
        } else {
            $this->mailDescription = "Your account has Been Rejected the rejection reason is given below.<br>".$rejectionReason;
        }
        $this->loginUlr = $loginUlr;
    }

    public function build()
    {
        return $this->view('emails.vendor-approval', [
            'type' => $this->type,
            'mailHeading' => $this->mailHeading,
            'mailDescription' => $this->mailDescription,
            'loginUrl' => $this->loginUlr
        ]);
    }
}
