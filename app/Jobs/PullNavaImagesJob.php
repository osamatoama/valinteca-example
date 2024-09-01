<?php

namespace App\Jobs;

use App\Models\Data;
use App\Services\SallaWebhookService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class PullNavaImagesJob implements ShouldQueue
{

    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $api_key;

    public $page;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($api_key, $page)
    {
        $this->api_key = $api_key;
        $this->page = $page;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {

        $salla = new SallaWebhookService($this->api_key);
        $products = $salla->getProducts($this->page)['data'];
        foreach ($products as $product) {
            $images = [];
            $images[] = $product['main_image'];
            foreach ($product['images'] as $productImage) {
                $images[] = $productImage['url'];
            }

            foreach ($images as $image) {
                Data::create([
                    'salla_id' => $product['id'],
                    'data'     => $image,
                ]);

            }

        }


    }
}
