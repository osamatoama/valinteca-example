<?php /** @noinspection NullPointerExceptionInspection */

namespace App\Exports;

use App\Models\Data;
use App\Models\Store;
use Illuminate\Support\Str;
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

class DataExport implements ShouldAutoSize, WithMapping, WithColumnFormatting, WithHeadings, WithEvents, FromCollection, WithCustomStartCell, WithTitle
{

    use Exportable;

    private $request;

    public function __construct()
    {
    }

    public function collection()
    {
        $data = Data::all();
        $exportedData = [];
        foreach ($data as $row) {
            $dd = $row->data;

            $exportedData[] = [
                'name'   => $dd['name'],
                'email'  => $dd['email'],
                'mobile' => Str::replace(' ', '', $dd['mobile']),
            ];

        }

        return collect($exportedData);

    }

    public function map($order): array
    {
        return [
            $order['name'] ?? '-----',
            $order['email'] ?? '-----',
            $order['mobile'] ?? '-----',

        ];
    }

    public function headings(): array
    {
        return [
            'اسم العميل',
            'الايميل',
            'الجوال',
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $event->sheet->getDelegate()->setRightToLeft(true);
                foreach (['A', 'B', 'C', 'D', 'E', 'F', 'G'] as $column) {
                    $event->sheet->getStyle($column . ':' . $column)->getAlignment()->setHorizontal('right');
                }
                $event->sheet->getStyle('A1:G1')->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('FFFFF000')->applyFromArray([
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
