<?php

namespace App\Jobs;

use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SyncSerdabAbayaItemSkuToGoogleSheet implements ShouldQueue
{

    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $item;

    public $tries = 5;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($item)
    {
        $this->item = $item;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        // order number	SKU	Status	Quantity	Size	Order Date


        $item = $this->item;
        $order = $item->order;


        $newArr = [];
        $newArr[] = $order->order_number;
        $newArr[] = $item->sku;
        $newArr[] = $order->order_status;
        $newArr[] = $item->quantity;
        $newArr[] = blank($item->size) ?? '';
        $newArr[] = Carbon::parse($order->order_date)->format('Y/m/d');


        // $newArr[] = ;

        serdabAbayaGoogleSheet($newArr);
    }
}
