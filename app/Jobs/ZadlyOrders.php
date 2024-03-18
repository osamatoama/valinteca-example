<?php

namespace App\Jobs;

use App\Services\SallaWebhookService;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ZadlyOrders implements ShouldQueue
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
            foreach ($order['items'] as $item) {
                \App\Models\ZadlyOrders::create([
                    'purchase_product' => $item['name'],
                    'customer_id'      => $order['customer']['id'],
                    'phone'            => $order['customer']['mobile_code'] . $order['customer']['mobile'],
                    'purchase_date'    => Carbon::parse($order['date']['date'])->format('Y-m-d'),
                    'quantity'         => $item['quantity'],
                    'amount'           => $item['amounts']['total']['amount'],
                ]);
            }

        }
    }
}
