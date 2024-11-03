<?php

namespace App\Jobs\Google;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SyncOrderToGoogleSheetsJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct(
        public Order $order,
    ) {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        foreach ($this->order->orderItems as $key => $orderItem) {
            AppendOrderItemToGoogleSheetsJob::dispatch(
                order: $this->order,
                orderItem: $orderItem,
            )->onQueue('google');
        }

        $this->order->update(
            attributes: [
                'is_synced' => true,
            ],
        );
    }
}
