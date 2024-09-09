<?php

namespace App\Jobs;

use App\Services\SallaWebhookService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class AywaCardsCheckPage implements ShouldQueue
{

    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $page;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($page)
    {
        $this->page = $page;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $api_key = 'ory_at_Rh20QltusYnf6i40H7N9MUBgsDLJdgAMuaILXwonT3Y.SNaYDx-Yv8lQjTSKDUGdCvF3ImZ3gO2pnHW24xgQVzM';
        $salla = new SallaWebhookService($api_key);
        $orders = $salla->getOrders($this->page);

        foreach ($orders['data']  as $order) {
            dispatch(new AywaCardsPullOrderJob($order['id']))->onQueue('pull-order');
        }

    }
}
