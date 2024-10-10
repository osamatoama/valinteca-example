<?php

namespace App\Jobs;

use App\Models\HaqoolProduct;
use App\Services\SallaWebhookService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class HaqoolPullProductsJob implements ShouldQueue
{

    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $api_key;

    public $page;

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
        $products = $salla->getProducts($this->page);

        foreach ($products['data'] as $product) {

            $brandName = '';
            if (isset($product['brand'])) {
                $brandName = $product['brand']['name'];
            }


            if (HaqoolProduct::where('product_id', $product['id'])->exists()) {
                return;
            }

            HaqoolProduct::create([
                'product_id'   => $product['id'],
                'product_name' => $product['name'],
                'brand'        => $brandName,
                'cost'         => $product['cost_price'],
            ]);


        }
    }
}
