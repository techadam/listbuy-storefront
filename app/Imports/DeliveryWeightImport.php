<?php

namespace App\Imports;

use App\Models\DeliveryWeight;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class DeliveryWeightImport implements ToModel, WithHeadingRow
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        return new DeliveryWeight([
           'weight' => $row['weight']
        ]);
    }
}
