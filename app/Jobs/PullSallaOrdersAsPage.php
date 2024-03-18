<?php

namespace App\Jobs;

use App\Models\SbaikSallaOrders;
use App\Services\SallaWebhookService;
use Carbon\Carbon;
use Exception;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class PullSallaOrdersAsPage implements ShouldQueue
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
        $orders = $salla->getOrders($this->page);
        foreach ($orders['data'] as $order) {
            SbaikSallaOrders::create([
                'customer_id'        => $order['customer']['id'],
                'email'              => $order['customer']['email'],
                'mobile'             => $order['customer']['mobile_code'] . $order['customer']['mobile'],
                'sales_order_number' => $order['reference_id'],
                'sales_amount'       => $order['amounts']['total']['amount'],
                'order_date'         => Carbon::parse($order['date']['date'])->format('Y-m-d'),
            ]);
        }
    }
}
