<?php

namespace App\Jobs;

use App\Models\BestShieldOrder;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class BestShieldPullOrderJob implements ShouldQueue
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
        $order = $this->order;

        if (BestShieldOrder::where('order_number', $order['reference_id'])->exists()) {
            return;
        }

        $couponName = '';
        $couponDiscount = 0;
        foreach ($order['amounts']['discounts'] as $discount) {
            if ($discount['type'] == null) {
                $couponName = $discount['code'];
                $couponDiscount = $discount['discount'];
            }
        }
        BestShieldOrder::create([

            'salla_order_id'   => $order['id'],
            'order_number'     => $order['reference_id'],
            'order_date'       => Carbon::parse($order['date']['date'])->format('Y-m-d H:i:s'),
            'order_status'     => $order['status']['name'],
            'client_name'      => $order['customer']['first_name'] . ' ' . $order['customer']['last_name'],
            'client_phone'     => $order['customer']['mobile_code'] . ' ' . $order['customer']['mobile'],
            'client_city'      => $order['customer']['city'],
            'client_country'   => $order['customer']['country'],
            'shipping_country' => $order['shipping']['pickup_address']['country'],
            'shipping_city'    => $order['shipping']['pickup_address']['city'],
            'payment_method'   => $order['payment_method'],
            'order_total'      => $order['amounts']['total']['amount'],
            'coupon'           => $couponName,
            'total_discount'   => $couponDiscount,
        ]);


    }
}
