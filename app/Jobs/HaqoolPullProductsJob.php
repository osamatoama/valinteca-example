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
        $api_key = 'ory_at_sfyIZg2otcS7e9nZL7TeOsFxScHCMAuKU5k2pLwKt6U.k7aZ4IN9AsQF6m8suBMjalusBkc_ZEjlK1ovqOHYMO8';
        $salla = new SallaWebhookService($api_key);
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
