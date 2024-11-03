<?php

namespace App\Jobs;

use App\Models\SerdabAbayaOrders;
use App\Services\SallaWebhookService;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SerdabCheckPage implements ShouldQueue
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
            $serdabOrder = SerdabAbayaOrders::create([
                'salla_order_id' => $order['id'],
                'order_number'   => $order['reference_id'],
                'order_status'   => $order['status']['name'],
                'order_date'     => Carbon::parse($order['date']['date'])->format('Y-m-d H:i:s'),
            ]);

            foreach ($order['items'] as $item) {
                $serdabOrder->items()->create([
                    'salla_order_number' => $order['id'],
                    'sku'                => $item['sku'],
                ]);
            }
        }

    }
}
