<?php

namespace App\Jobs;

use App\Models\HaqoolOrder;
use App\Models\HaqoolProduct;
use App\Services\SallaWebhookService;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class HaqoolPullOrderJob implements ShouldQueue
{

    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $order;

    public $api_key;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($order, $api_key)
    {
        $this->order = $order;
        $this->api_key = $api_key;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $order = $this->order;
        if (HaqoolOrder::where('order_number', $order['reference_id'])->exists()) {
            return;
        }

        foreach ($order['items'] as $item) {
            $brand = '';
            $cost = '';
            $product = HaqoolProduct::where('product_id', $item['product']['id'])->first();
            if (filled($product)) {
                $brand = $product->brand;
                $cost = $product->cost;
            }
            HaqoolOrder::create([
                'product_name'   => $item['name'],
                'sku'            => $item['sku'],
                'brand'          => $brand,
                'cost'           => $cost,
                'quantity'       => $item['quantity'],
                'total'          => $item['amounts']['total']['amount'],
                'order_number'   => $order['reference_id'],
                'salla_order_id' => $order['id'],
                'order_date'     => Carbon::parse($order['date']['date'])->format('Y-m-d H:i:s'),
                'order_status'   => $order['status']['name'],
                'client_name'    => $order['customer']['first_name'] . ' ' . $order['customer']['last_name'],
                'client_email'   => $order['customer']['email'],
                'client_phone'   => $order['customer']['mobile_code'] . ' ' . $order['customer']['mobile'],
                'client_city'    => $order['customer']['city'],
                'payment_method' => $order['payment_method'],
            ]);
        }

        dispatch(new HaqoolPullOrderInvoiceJob($order,$this->api_key))->onQueue('pull-order')->delay(now()->addSeconds(3));
    }
}
