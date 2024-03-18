<?php

namespace App\Exports;

use App\Models\GroupNumber;
use App\Models\Number;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class WhatsNumbersExport implements FromCollection, WithHeadings
{

    /**
     * @return \Illuminate\Support\Collection
     */
    public $data;

    public function __construct($data)
    {
        $this->data = $data;
    }

    public function collection()
    {
        $numbers_data = collect([]);

        foreach ($this->data as $singleData) {
            if ($singleData['type'] === 'user'){
                $numbers_data->push([
                    'name'   => $singleData['name'],
                    'number' => get_number($singleData['id']),
                    'group'  => '',
                    'gender' => '',
                ]);
            }
        }

        return $numbers_data;
    }

    public function headings(): array

    {
        return [
            'name',
            'number',
            'group',
            'gender',
        ];
    }
}
