<?php

namespace App\Jobs;

use App\Models\AbayaOptions;
use App\Models\AbayaOrders;
use App\Models\AbayaProductOptions;
use App\Models\AbayaProducts;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Str;

class SyncAbayaOrderJob implements ShouldQueue
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
        $createdOrder = AbayaOrders::firstOrCreate([
            'reference_id' => $order['reference_id'],
        ], [
            'salla_id'     => $order['id'],
            'reference_id' => $order['reference_id'],
        ]);

        foreach ($order['items'] as $item) {
            $product = $item['product'];

            $createdProduct = AbayaProducts::firstOrCreate([
                'salla_id' => $product['id'],
            ], [
                'salla_id'  => $product['id'],
                'name'      => $product['name'],
                'thumbnail' => $product['thumbnail'],

            ]);


            foreach ($item['options'] as $option) {
                $createdOption = AbayaOptions::firstOrCreate([
                    'option_id' => $option['id'],
                ], [
                    'option_id' => $option['id'],
                    'name'      => $option['name'],
                ]);
                $createdProductOptions = AbayaProductOptions::firstOrCreate([
                    'product_id' => $product['id'],
                    'option_id'  => $option['id'],
                ], [
                    'reference_id' => $order['reference_id'],
                    'product_id'   => $product['id'],
                    'option_id'    => $option['id'],
                    'value'        => Str::replace(['مقاس', ' '], '', $option['value']['name']),
                    'quantity'     => $item['quantity'],
                ]);


            }
        }
    }
}
