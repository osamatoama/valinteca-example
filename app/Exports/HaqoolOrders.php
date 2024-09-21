<?php /** @noinspection NullPointerExceptionInspection */

namespace App\Exports;

use App\Models\HaqoolOrder;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithCustomStartCell;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithTitle;

class HaqoolOrders implements ShouldAutoSize, WithMapping, WithColumnFormatting, WithHeadings, FromCollection, WithCustomStartCell, WithTitle
{

    use Exportable;

    private $request;

    public function __construct()
    {
    }

    public function collection()
    {
        $data = HaqoolOrder::orderBy('order_date', 'ASC')->get();
        $exportedData = [];
        foreach ($data as $row) {
            $exportedData[] = [
                'product_name'   => $row['product_name'],
                'sku'            => $row['sku'],
                'brand'          => $row['brand'],
                'cost'           => $row['cost'],
                'quantity'       => $row['quantity'],
                'total'          => $row['total'],
                'order_number'   => $row['order_number'],
                'order_date'     => $row['order_date'],
                'order_status'   => $row['order_status'],
                'client_name'    => $row['client_name'],
                'client_email'   => $row['client_email'],
                'client_phone'   => $row['client_phone'],
                'client_city'    => $row['client_city'],
                'payment_method' => $row['payment_method'],
                'invoice_number' => $row['invoice_number'],

            ];

        }

        return collect($exportedData);

    }

    public function map($order): array
    {
        return [
            $order['product_name'],
            $order['sku'],
            $order['brand'],
            $order['cost'],
            $order['quantity'],
            $order['total'],
            $order['order_number'],
            $order['order_date'],
            $order['order_status'],
            $order['client_name'],
            $order['client_email'],
            $order['client_phone'],
            $order['client_city'],
            $order['payment_method'],
            $order['invoice_number'],

        ];
    }

    public function headings(): array
    {
        return [
            'product name',
            'sku',
            'brand',
            'cost',
            'quantity',
            'total',
            'order number',
            'order date',
            'order status',
            'client name',
            'client email',
            'client phone',
            'client city',
            'payment method',
            'invoice_number',
        ];
    }

    public function columnFormats(): array
    {
        return [
            'B' => '#',
        ];
    }

    public function startCell(): string
    {
        return 'A1';
    }

    public function title(): string
    {
        return 'الطلبات - سلة';
    }

}
