<?php /** @noinspection NullPointerExceptionInspection */

namespace App\Exports;

use App\Models\HaqoolOrder;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;

class HaqoolOrders implements FromCollection, ShouldAutoSize, WithHeadings
{

    use Exportable;

    private $request;

    public function __construct()
    {
    }

    public function collection()
    {
        return HaqoolOrder::select('product_name', 'sku', 'brand', 'cost', 'quantity', 'total', 'order_number',
            'order_date', 'order_status', 'client_name', 'client_email', 'client_phone', 'client_city',
            'payment_method', 'invoice_number', 'salla_order_id')->orderBy('order_date', 'ASC')->get();

    }

    /*
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
        }*/

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

}
