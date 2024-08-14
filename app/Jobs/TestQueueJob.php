<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Http;

class TestQueueJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $tries = 0;

    public $message;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($message)
    {
        $this->message = $message;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        sleep(2);

        $response = Http::post(
            'https://api.green-api.com/waInstance1101888590/sendMessage/22752bf9fad745fdbff8ec9a3b03f16020ec0ae51b6e4df9a6',
            [
                'chatId' => '201551747425@c.us',
                'message' => "Message: {$this->message}",
            ],
        );
    }
}
