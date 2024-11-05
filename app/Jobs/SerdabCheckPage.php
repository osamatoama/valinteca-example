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
            $order_status = $order['status']['name'];
            if (isset($order['status']['customized'])) {
                $order_status = $order['status']['customized']['name'];
            }
            $serdabOrder = SerdabAbayaOrders::create([
                'salla_order_id' => $order['id'],
                'order_number'   => $order['reference_id'],
                'order_status'   => $order_status,
                'order_date'     => Carbon::parse($order['date']['date'])->format('Y-m-d H:i:s'),
            ]);

            foreach ($order['items'] as $item) {
                $size = null;
                foreach ($item['options'] as $option) {
                    if (isset($option['name'])) {

                        if ($option['name'] == 'القياس' || $option['name'] == 'المقاس') {
                            $size = $option
                            ['value']
                            ['name'];
                        }
                    }

                }

                $serdabOrder->items()->create([
                    'salla_order_number' => $order['id'],
                    'sku'                => blank($item['sku']) ? null : $item['sku'],
                    'status'             => $order_status,
                    'quantity'           => $item['quantity'],
                    'size'               => $size,
                    'order_date'         => Carbon::parse($order['date']['date'])->format('Y-m-d H:i:s'),
                ]);
            }
        }

    }
}
