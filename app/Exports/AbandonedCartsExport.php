<?php /** @noinspection NullPointerExceptionInspection */

namespace App\Exports;

use App\Models\AbandonedCarts;
use App\Models\Store;
use App\Services\PricesService;
use App\Services\SallaWebhookService;
use Carbon\Carbon;
use Exception;
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
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;

class AbandonedCartsExport implements ShouldAutoSize, WithMapping, WithColumnFormatting, WithHeadings, WithEvents, FromCollection, WithCustomStartCell, WithTitle
{

    use Exportable;

    private $store;

    private $request;

    public function __construct(Store $store, $request)
    {
        $this->store = $store;
        $this->request = $request;
    }

    public function collection()
    {

        $data = AbandonedCarts::whereStoreId($this->store->id)->when($this->request->has('total_type') && $this->request->filled('total_value'),
                function ($builder) {

                    $builder->when(request('total_type') == 'less', function ($builder) {
                            $builder->where('total', '<', request('total_value'));
                        })->when(request('total_type') == 'more', function ($builder) {
                            $builder->where('total', '>', request('total_value'));
                        });
                })->when($this->request->has('date_type') && $this->request->filled('date_value'), function ($builder) {
                $builder->when(request('date_type') == 'less', function ($builder) {
                        $builder->where('updated_at', '<', now()->subDays(request('date_value')));
                    })->when(request('date_type') == 'more', function ($builder) {
                        $builder->where('updated_at', '>', now()->addDays(request('date_value')));
                    });
            })->get();


        return collect($data);
    }

    public function map($cart): array
    {

        return [
            $cart['name'] ?? '-----',
            $cart['phone'] ?? '-----',
            $cart['total'] ?? '-----',
            $cart['updated_at'] ?? '-----',
        ];
    }

    public function headings(): array
    {
        return [
            'اسم العميل',
            'رقم العميل',
            'مجموع السلة',
            'آخر تحديث',
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
        return 'السلات المتروكة';
    }

}
