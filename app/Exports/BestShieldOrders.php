<?php /** @noinspection NullPointerExceptionInspection */

namespace App\Exports;

use App\Models\BestShieldOrder;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;

class BestShieldOrders implements FromCollection, ShouldAutoSize, WithHeadings
{

    use Exportable;

    private $request;

    public function __construct()
    {
    }

    public function collection()
    {
        return BestShieldOrder::select('salla_order_id', 'order_number', 'order_date', 'order_status', 'client_name',
            'client_phone', 'client_city', 'client_country', 'payment_method', 'order_total', 'total_discount', 'shipping_country', 'coupon', 'shipping_city')->orderBy('order_date', 'ASC')->get();

    }

    public function headings(): array
    {
        return [
            'salla_order_id',
            'order_number',
            'order_date',
            'order_status',
            'client_name',
            'client_phone',
            'client_city',
            'client_country',
            'payment_method',
            'order_total',
            'total_discount',
            'payload',
            'shipping_country',
            'coupon',
            'shipping_city',
        ];
    }

}
