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

class BestShieldPullOrderShipmentJob implements ShouldQueue
{

    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $orderId;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($orderId)
    {
        $this->orderId = $orderId;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $api_key = 'ory_at_udjzu3ce7VmRiWo6j92GxE5VjlQYFYKPI2RTdKalR-M.Xb-LGi1gYNoNSrC0nRluosRXUDnjVWEBvt8XNkl3C-0';
        $salla = new SallaWebhookService($api_key);
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
