<?php

namespace App\Jobs;

use App\Models\Code;
use App\Services\SallaWebhookService;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class AywaCardsPullOrderJob implements ShouldQueue
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
        $api_key = 'ory_at_Rh20QltusYnf6i40H7N9MUBgsDLJdgAMuaILXwonT3Y.SNaYDx-Yv8lQjTSKDUGdCvF3ImZ3gO2pnHW24xgQVzM';
        $salla = new SallaWebhookService($api_key);
        $order = $salla->getOrder($this->order);

        foreach ($order['data']['items'] as $item) {
            foreach ($item['codes'] as $code) {

                Code::create([
                    'salla_id'     => $order['data']['id'],
                    'order_id'     => $order['data']['reference_id'],
                    'code'         => $code['code'],
                    'product_name' => $item['name'],
                    'status'       => $code['status'],
                    'order_date'   => Carbon::parse($order['data']['date']['date']),
                ]);


            }
        }
    }
}
