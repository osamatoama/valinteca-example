<?php

namespace App\Jobs;

use App\Models\SbaikSallaOrders;
use App\Services\SallaWebhookService;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class PullSingleOrderJob implements ShouldQueue
{

    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $backoff = 3;

    public $tries = 10;

    public $order;

    public $api_key;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($order, $api_key)
    {
        $this->order = $order;
        $this->api_key = $api_key;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {



    }
}
