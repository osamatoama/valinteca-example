<?php

namespace App\Jobs\Google;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SyncOrdersToGoogleSheetsJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        Order::query()
            ->has(
                relation: 'orderItems',
            )
            ->where(
                column: 'is_synced',
                operator: '=',
                value: false,
            )
            ->where(
                column: 'matches',
                operator: '=',
                value: true,
            )
            ->latest(
                column: 'reference_id',
            )
            ->each(
                callback: function (Order $order) {
                    SyncOrderToGoogleSheetsJob::dispatch(
                        order: $order,
                    )->onQueue('google');
                },
            );
    }
}
