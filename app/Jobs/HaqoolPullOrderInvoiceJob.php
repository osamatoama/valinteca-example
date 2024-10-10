<?php

namespace App\Jobs;

use App\Models\HaqoolInvoices;
use App\Models\HaqoolOrder;
use App\Services\SallaWebhookService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class HaqoolPullOrderInvoiceJob implements ShouldQueue
{

    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

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
        $order = $this->order;
        $salla = new SallaWebhookService($this->api_key);
        $invoices = $salla->getOrderInvoice($order['id']);
        $invoiceNumber = '';
        foreach ($invoices['data'] as $invoice) {

            HaqoolInvoices::create([
                'order_number'   => $order['reference_id'],
                'customer_name'  => $order['customer']['first_name'] . ' ' . $order['customer']['last_name'],
                'invoice_number' => $invoice['invoice_number'],
                'invoice_type'   => $invoice['type'],
                'invoice_date'   => $invoice['date'],
                'sub_total'      => $invoice['sub_total']['amount'],
                'discount'       => $invoice['discount']['amount'],
                'shipping'       => $invoice['shipping_cost']['amount'],
                'vat'            => $invoice['tax']['amount']['amount'],
                'total'          => $invoice['total']['amount'],
            ]);

            if ($invoice['type'] == 'Tax Invoice') {
                $invoiceNumber = $invoice['invoice_number'];
            }
        }

        HaqoolOrder::where('salla_order_id', $order['id'])->update([
            'invoice_number' => $invoiceNumber,
        ]);


    }
}
