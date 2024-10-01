<?php

namespace App\Jobs;

use App\Services\SallaWebhookService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class HaqoolCheckPage implements ShouldQueue
{

    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $page;

    public $api_key;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($page, $api_key)
    {
        $this->page = $page;
        $this->api_key = $api_key;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $salla = new SallaWebhookService($this->api_key);
        $orders = $salla->getOrdersLatest($this->page);

        foreach ($orders['data'] as $order) {
            dispatch(new HaqoolPullOrderJob($order,$this->api_key))->onQueue('pull-order');
        }

    }
}
