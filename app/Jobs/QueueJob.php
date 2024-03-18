<?php

namespace App\Jobs;

use App\Mail\CerMail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class QueueJob implements ShouldQueue
{

    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $email;

    public $key;

    public $name;

    /**
     * Create a new job instance.
     *
     * @param $email
     * @param $key
     * @param $name
     */
    public function __construct($email, $key, $name)
    {
        $this->key = $key;
        $this->email = $email;
        $this->name = $name;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        Mail::to($this->email)->send(new CerMail($this->key, $this->name));
    }
}
