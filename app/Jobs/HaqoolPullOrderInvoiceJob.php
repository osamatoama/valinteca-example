<?php

namespace App\Jobs;

use App\Models\HaqoolOrder;
use App\Models\HaqoolProduct;
use App\Services\SallaWebhookService;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class HaqoolPullOrderInvoiceJob implements ShouldQueue
{

    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $orderId;
    public $api_key;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($orderId,$api_key)
    {
        $this->orderId = $orderId;
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
        $invoices = $salla->getOrderInvoice($this->orderId);
        $invoiceNumber = '';
        foreach ($invoices['data'] as $invoice) {
            if($invoice['type'] == 'Tax Invoice') {
                $invoiceNumber = $invoice['invoice_number'];
            }
        }

        HaqoolOrder::where('salla_order_id', $this->orderId)->update([
            'invoice_number' =>  $invoiceNumber
        ]);

    }
}
