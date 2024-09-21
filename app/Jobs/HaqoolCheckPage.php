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
        $api_key = 'ory_at_ed7IeC2KzPPXrjzOJv3BjqzmnyACebzC7joHRma-Mx8.2C1P-evQord1wsWeOMDoWiQDiwQIcvZ4bm5774cMNUs';
        $salla = new SallaWebhookService($api_key);
        $orders = $salla->getOrdersLatest($this->page);

        foreach ($orders['data']  as $order) {
            dispatch(new HaqoolPullOrderJob($order['id']))->onQueue('pull-order');
        }

    }
}
