<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class AywaCardsLoopPages implements ShouldQueue
{

    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $pages;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($pages)
    {
        $this->pages = $pages;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        foreach ($this->pages as $page) {
            dispatch(new AywaCardsCheckPage($page));
        }

    }
}
