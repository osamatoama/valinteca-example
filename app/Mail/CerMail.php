<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class CerMail extends Mailable
{

    use Queueable, SerializesModels;

    public $key;

    public $name;

    /**
     * Create a new message instance.
     *
     * @param $key
     * @param $name
     */
    public function __construct($key, $name)
    {
        $this->key = $key;
        $this->name = $name;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.test')->subject('شهادة حضور الدورة التدريبية')->attach(public_path('pdf/certificate-' . $this->key . '.pdf'));
    }
}
