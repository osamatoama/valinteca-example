<?php

namespace App\Jobs;

use App\Services\SallaWebhookService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class BestShieldCheckPage implements ShouldQueue
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
        $api_key = 'ory_at_udjzu3ce7VmRiWo6j92GxE5VjlQYFYKPI2RTdKalR-M.Xb-LGi1gYNoNSrC0nRluosRXUDnjVWEBvt8XNkl3C-0';
        $salla = new SallaWebhookService($api_key);
        $orders = $salla->getOrdersByCoupon($this->page, 'MN');

        foreach ($orders['data'] as $order) {
            dispatch(new BestShieldPullOrderJob($order))->onQueue('pull-order');
        }

    }
}