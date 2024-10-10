<?php /** @noinspection NullPointerExceptionInspection */

namespace App\Exports;

use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class HaqoolInvoices implements FromCollection, ShouldAutoSize, WithHeadings, WithMapping
{

    use Exportable;

    private $request;

    public function __construct()
    {
    }

    public function collection()
    {
        return \App\Models\HaqoolInvoices::all();

    }

    public function map($invoice): array
    {

        return [
            $invoice['order_number'],
            $invoice['customer_name'],
            $invoice['invoice_number'],
            $invoice['invoice_type'],
            $invoice['invoice_date'],
            $invoice['sub_total'],
            $invoice['discount'],
            $invoice['shipping'],
            $invoice['vat'],
            $invoice['total'],


        ];
    }

    public function headings(): array
    {
        return [
            'order_number',
            'customer_name',
            'invoice_number',
            'invoice_type',
            'invoice_date',
            'sub_total',
            'discount',
            'shipping',
            'vat',
            'total',
        ];
    }

}
