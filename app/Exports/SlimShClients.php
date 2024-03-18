<?php /** @noinspection NullPointerExceptionInspection */

namespace App\Exports;

use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithCustomStartCell;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Style\Fill;

class SlimShClients implements ShouldAutoSize, WithMapping, WithColumnFormatting, WithHeadings, WithEvents, FromCollection, WithCustomStartCell, WithTitle
{

    use Exportable;

    private $request;

    public function __construct()
    {
    }

    public function collection()
    {
        $data = \App\Models\SlimShClients::all();
        $exportedData = [];
        foreach ($data as $row) {
            $exportedData[] = [
                'product_id'   => $row['product_id'],
                'product_name' => $row['product_name'],
                'client_name'  => $row['client_name'],
                'client_email' => $row['client_email'],
                'client_phone' => $row['client_phone'],
            ];

        }

        return collect($exportedData);

    }

    public function map($order): array
    {
        return [
            $order['product_id'] ?? '-----',
            $order['product_name'] ?? '-----',
            $order['client_name'] ?? '-----',
            $order['client_email'] ?? '-----',
            $order['client_phone'] ?? '-----',

        ];
    }

    public function headings(): array
    {
        return [
            'product_id',
            'product_name',
            'client_name',
            'client_email',
            'client_phone',
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $event->sheet->getDelegate()->setRightToLeft(true);
                foreach (['A', 'B', 'C'] as $column) {
                    $event->sheet->getStyle($column . ':' . $column)->getAlignment()->setHorizontal('right');
                }
                $event->sheet->getStyle('A1:C1')->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('FFFFF000')->applyFromArray([
                    'font' => [
                        'bold' => true,
                    ],
                ]);
            },
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
