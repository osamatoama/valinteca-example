<?php

namespace App\Jobs;

use App\Models\Data;
use App\Services\SallaWebhookService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SlimShMenController implements ShouldQueue
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

        $products = [2009532614];
        foreach ($salla->getOrders($this->page)['data'] as $order) {
            foreach ($order['items'] as $item) {
                if (in_array($item['product']['id'], $products)) {
                    Data::create([
                        'data' => [
                            'name'   => $order['customer']['first_name'] . ' ' . $order['customer']['last_name'],
                            'mobile' => $order['customer']['mobile_code'] . ' ' . $order['customer']['mobile'],
                            'email'  => $order['customer']['email'],
                        ],
                    ]);
                }
            }
        }
    }
}
