<?php

namespace App\Jobs;

use App\Models\Order;
use App\Services\SallaWebhookService;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Str;

class SecondLevel implements ShouldQueue
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
        $salla = new SallaWebhookService('48bbd359c4561d01d92c831f3d21600712441f5a0934e11e411963e0c22d97c768f64db6275e6dd9daad3058bb568f9aa18b');
        $order = $this->order;
        $or = $salla->getOrder($order['id'])['data'];

        $h = $salla->getOrderHistories($order['id'])['data'];


        $data = [
            'order_number'     => $order['reference_id'],
            'total'            => $order['total']['amount'],
            'status'           => $order['status']['name'],
            'payment_method'   => $or['payment_method'],
            'customer'         => '',
            'date'             => Carbon::parse($or['date']['date'])->format('Y-m-d H:i:s'),
            'progress_date'    => null,
            'done_date'        => null,
            'deliver_progress' => null,
            'done_deliver'     => null,
            'return'           => null,
            'cancel'           => null,
        ];
        if (isset($or['customer'])) {
            $data['customer'] = $or['customer']['first_name'] . ' ' . $or['customer']['last_name'] . '<br />' . $or['customer']['mobile_code'] . $or['customer']['mobile'];

        }

        $progress_date = '';
        $done_date = '';
        $deliver_progress = '';
        $done_deliver = '';
        $return = '';
        $cancel = '';

        foreach ($h as $ssss) {
            $status = $ssss['status'];

            if (Str::contains($status, 'قيد التنفيذ') && blank($progress_date)) {
                $progress_date = Carbon::parse($ssss['created_at']['date'])->format('Y-m-d H:i:s');
                $data['progress_date'] = $progress_date;
            }
            if (Str::contains($status, 'تم التنفيذ') && blank($done_date)) {
                $done_date = Carbon::parse($ssss['created_at']['date'])->format('Y-m-d H:i:s');
                $data['done_date'] = $done_date;
            }
            if (Str::contains($status, 'جاري التوصيل') && blank($deliver_progress)) {
                $deliver_progress = Carbon::parse($ssss['created_at']['date'])->format('Y-m-d H:i:s');
                $data['deliver_progress'] = $deliver_progress;
            }
            if (Str::contains($status, 'تم التوصيل') && blank($done_deliver)) {
                $done_deliver = Carbon::parse($ssss['created_at']['date'])->format('Y-m-d H:i:s');
                $data['done_deliver'] = $done_deliver;
            }
            if (Str::contains($status, 'ملغي') && blank($cancel)) {
                $cancel = Carbon::parse($ssss['created_at']['date'])->format('Y-m-d H:i:s');
                $data['cancel'] = $cancel;
            }

            if (Str::contains($status, 'مسترجع') && blank($return)) {
                $return = Carbon::parse($ssss['created_at']['date'])->format('Y-m-d H:i:s');
                $data['return'] = $return;
            }


        }

        Order::create([
            'data' => $data,
        ]);
    }
}
