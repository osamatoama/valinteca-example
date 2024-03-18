<?php

namespace App\Jobs;

use App\Models\Abaya;
use App\Services\SallaWebhookService;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class AbayaJob implements ShouldQueue
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
        $orders = $salla->getOrdersDateRange($this->page);
        foreach ($orders['data'] as $order) {
            $orderDate = Carbon::parse($order['date']['date'])->format('Y-m-d');
            $abayaCheck = Abaya::where('date', $orderDate)->first();
            if (filled($abayaCheck)) {
                $abayaCheck->update([
                    'revenue' => $abayaCheck->revenue + $order['amounts']['total']['amount'],
                ]);
                $abayaCheck->increment('translations', 1);
            } else {
                Abaya::create([
                    'date'         => $orderDate,
                    'revenue'      => $order['amounts']['total']['amount'],
                    'translations' => 1,
                ]);
            }
        }
    }
}
