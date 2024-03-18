<?php /** @noinspection NullPointerExceptionInspection */

namespace App\Exports;

use App\Models\Number;
use App\Models\Store;
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

class ClientNumberExport implements ShouldAutoSize, WithMapping, WithColumnFormatting, WithHeadings, WithEvents, FromCollection, WithCustomStartCell, WithTitle
{

    use Exportable;

    private $store;
    private $numbers;
    private $request;

    public function __construct(Store $store, $numbers, $request)
    {
        $this->store = $store;
        $this->numbers = $numbers;
        $this->request = $request;
    }

    public function collection()
    {
        return collect($this->numbers);
    }

    public function map($number): array
    {
        return [
            $number->name ?? '-----',
            $number->number ?? '-----',
            $number->email ?? '-----',
            'عملاء سلة',
            $number->gender ?? '-----',
        ];
    }

    public function headings(): array
    {
        return [
            'name',
            'number',
            'email',
            'group',
            'gender',
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $event->sheet->getDelegate()->setRightToLeft(true);
                foreach (['A', 'B', 'C', 'D'] as $column) {
                    $event->sheet->getStyle($column . ':' . $column)->getAlignment()->setHorizontal('right');
                }
                $event->sheet->getStyle('A1:D1')->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('FFFFF000')->applyFromArray([
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
        return 'أرقام العملاء - سلة';
    }

}
