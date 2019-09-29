<?php

namespace App\Imports;

use App\Models\States;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class StatesImport implements ToModel, WithHeadingRow
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        return new States([
            'code' => \strtolower($row['code']),
            'name' => ucfirst(\strtolower($row['name'])),
        ]);
    }
}
