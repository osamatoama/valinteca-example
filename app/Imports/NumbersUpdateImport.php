<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class NumbersUpdateImport implements ToCollection ,  WithValidation ,WithHeadingRow
{
    /**
    * @param Collection $collection
    */
    public function collection(Collection $collection)
    {
        foreach ($collection as $row)
        {
            $number = user()->numbers()->create([
                'name'     => $row['name'],
                'number'    => $row['number'],
                'user_id' => user()->id ,
            ]);

            $group = user()->groups()->same($row['group'])->first();

            if(!filled($group)){
                $group =  user()->groups()->create([
                    'name' => $row['group'],
                    'user_id' => user()->id ,
                ]);
            }

            user()->groupnumbers()->create([
                'number_id' => $number->id ,
                'group_id' => $group->id ,
                'user_id' => user()->id ,
            ]);

        }
    }
    public function rules(): array
    {
        return [
            '*.number' => 'required|unique:numbers,number',
            '*.group' =>'required',
        ];
    }
}
