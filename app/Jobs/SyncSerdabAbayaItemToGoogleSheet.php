<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SyncSerdabAbayaItemToGoogleSheet implements ShouldQueue
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
        $skus = '';
        $newArr = [];
        $newArr[] = $order->order_number;
        $newArr[] = $order->order_status;
        $newArr[] = $order->order_date;
        foreach ($order->items as $item) {
            $skus .= $item->sku . ' ';
            $newArr[] = $item->sku;
        }

        $newArr[] = $skus;

        serdabAbayaGoogleSheet($newArr);
    }
}
