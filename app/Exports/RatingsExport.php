<?php

namespace App\Exports;

use App\Models\Rating;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class RatingsExport implements FromCollection, WithHeadings
{

    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        $data = collect([]);

        $ratings = Rating::all();

        foreach ($ratings as $rating) {
            $data->push([
                'salla_id' => $rating->salla_id,
                'url'      => $rating->url,
                'name'     => $rating->name,
                'content'  => $rating->content,
                'stars'    => $rating->stars,
            ]);
        }

        return $data;
    }

    public function headings(): array

    {
        return [
            'salla_id',
            'url',
            'name',
            'content',
            'stars',
        ];
    }
}
