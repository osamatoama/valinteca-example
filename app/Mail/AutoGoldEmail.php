<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class AutoGoldEmail extends Mailable
{

    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     */
    public function __construct()
    {

    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.autogold')->subject('اوتو جولد لتحديث اسعار الذهب ');
    }
}
