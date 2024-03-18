<?php

namespace App\Exports;

use Illuminate\Database\Eloquent\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;

class SampleExport implements FromCollection
{

    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return new Collection([
            ['name', 'number', 'group', 'gender'],
            ['Mohamed', +96655000000, 'KSA', 'male'],
        ]);

    }
}
