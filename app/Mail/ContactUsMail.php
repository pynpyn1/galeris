<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ContactUsMail extends Mailable
{
    use Queueable, SerializesModels;

    public $data;

    public function __construct($data)
    {
        $this->data = $data;
    }

    public function build()
    {
        return $this->from(env('MAIL_FROM_ADDRESS'), env('MAIL_FROM_NAME'))
                    ->replyTo($this->data['email'], $this->data['name'])
                    ->to(env('CONTACT_US_EMAIL', 'noname@ngasinan-bulu-sukoharjo.com'))
                    ->subject($this->data['subject'])
                    ->view('emails.contactus')
                    ->with(['data' => $this->data]);
    }

}
