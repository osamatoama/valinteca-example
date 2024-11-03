<?php

namespace App\Jobs\Google;

use App\Jobs\Concerns\InteractsWithException;
use App\Models\Order;
use App\Models\OrderItem;
use App\Services\Google\Sheets\GoogleSheetsException;
use App\Services\Google\Sheets\GoogleSheetsService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class AppendOrderItemToGoogleSheetsJob implements ShouldQueue
{
    use Dispatchable, InteractsWithException, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct(
        public Order $order,
        public OrderItem $orderItem,
    ) {
        $this->maxAttempts = 1;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $service = new GoogleSheetsService(
            spreadsheetId: config(
                key: 'google.spreadsheet_id',
            ),
            sheetName: config(
                key: 'google.sheet_name',
            ),
            range: '',
        );

        try {
            $response = $service->append(
                data: [
                    $this->order->customer_name,
                    $this->order->customer_mobile,
                    $this->order->reference_id,
                    $this->orderItem->name ?? '',
                    $this->orderItem->url,
                    $this->orderItem->karat ?? '',
                    $this->orderItem->weight,
                    $this->orderItem->color ?? '',
                    $this->orderItem->size ?? '',
                    $this->orderItem->design ?? '',
                    $this->order->created_by ?? '',
                    $this->orderItem->notes ?? '',
                    $this->order->order_date ?? '',

                ],
            );
        } catch (GoogleSheetsException $exception) {
            $this->handleException(
                exception: GoogleSheetsException::fromException(
                    exception: $exception,
                    lines: [
                        'Exception while appending to google sheets',
                        "OrderId: {$this->order->id}",
                        "OrderItemId: {$this->order->id}",
                    ],
                ),
            );

            return;
        }

        $this->orderItem->update(
            attributes: [
                'range' => $response['range'],
                'row' => $response['row'],
            ],
        );
    }
}
