<?php

namespace App\Jobs;

use App\Services\SallaWebhookService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SyncAbayaOrdersJob implements ShouldQueue
{

    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    public $tries = 3;
    public $api_key;

    public $page;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($api_key, $page)
    {
        $this->api_key = $api_key;
        $this->page = $page;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {

        $salla = new SallaWebhookService($this->api_key);

        foreach ($salla->getOrdersForAbaya($this->page)['data'] as $order) {
            dispatch(new SyncAbayaOrderJob($order))->onQueue('pull');
        }
    }
}
