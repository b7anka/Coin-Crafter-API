<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class ContactedUsMail extends Mailable
{
    use Queueable, SerializesModels;

    public $data;

    public function __construct($data)
    {
        $this->data = $data;
    }

    public function build()
    {
        $name = $this->data["name"];
        $subject = "New contact request from $name";
        return $this->view('emails.request_contact')
            ->subject($subject)
            ->from($this->data["email"], $name);
    }
}
