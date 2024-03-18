<?php

namespace App\Imports;

use App\Models\User;
use Exception;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class NumbersImport implements ToCollection, WithValidation, WithHeadingRow
{

    /**
     * @param Collection $collection
     */
    public function collection(Collection $collection)
    {
         foreach ($collection as $row) {

            User::create([
                'name' => $row['name'] ?? 'Osama Toama',
                'email' => $row['email'] ?? 'altoama@outlook.com',
                'password' => 1
            ]);

        }


    }

    public function rules(): array
    {
        return [
            //            '*.number' => 'required|unique:numbers,number',
            //  '*.number' => 'required',
            //'*.group' =>'required',
        ];
    }
}
