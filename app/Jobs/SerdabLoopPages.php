<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SerdabLoopPages implements ShouldQueue
{

    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $pages;

    public $api_key;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($pages, $api_key)
    {
        $this->pages = $pages;
        $this->api_key = $api_key;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        foreach ($this->pages as $page) {
            dispatch(new SerdabCheckPage($page, $this->api_key))->onQueue('pull-order');
        }
    }
}
