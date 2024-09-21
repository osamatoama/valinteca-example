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

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($order)
    {
        $this->order = $order;
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
        $order = $salla->getOrder($this->order);

        if (HaqoolOrder::where('order_number', $order['data']['reference_id'])->exists()) {
            return;
        }

        foreach ($order['data']['items'] as $item) {
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
                'order_number'   => $order['data']['reference_id'],
                'salla_order_id' => $order['data']['id'],
                'order_date'     => Carbon::parse($order['data']['date']['date'])->format('Y-m-d H:i:s'),
                'order_status'   => $order['data']['status']['name'],
                'client_name'    => $order['data']['customer']['first_name'] . ' ' . $order['data']['customer']['last_name'],
                'client_email'   => $order['data']['customer']['email'],
                'client_phone'   => $order['data']['customer']['mobile_code'] . ' ' . $order['data']['customer']['mobile'],
                'client_city'    => $order['data']['customer']['city'],
                'payment_method' => $order['data']['payment_method'],
                'payload'        => $order['data'],
            ]);
        }

        dispatch(new HaqoolPullOrderInvoiceJob($order['data']['id']))->onQueue('pull-order')->delay(now()->addSeconds(3));
    }
}
