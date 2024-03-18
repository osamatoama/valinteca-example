<?php

namespace App\Jobs;

use App\Models\SlimShClients;
use App\Services\SallaWebhookService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SlimShCientsJob implements ShouldQueue
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
        $selectedProducts = [1615976973, 734873097, 1857147238, 2116600792];
        $orders = $salla->getOrders($this->page);
        foreach ($orders['data'] as $order) {
            foreach ($order['items'] as $item) {
                $product = $item['product'];
                $customer = $order['customer'];
                $productId = $product['id'];
                if (in_array($productId, $selectedProducts)) {
                    SlimShClients::create([
                        'product_id'   => $productId,
                        'product_name' => $product['name'],
                        'client_name'  => sprintf('%s %s', $customer['first_name'], $customer['last_name']),
                        'client_email' => $customer['email'],
                        'client_phone' => sprintf('%s%s', $customer['mobile_code'], $customer['mobile']),
                    ]);
                }

            }

        }
    }
}
