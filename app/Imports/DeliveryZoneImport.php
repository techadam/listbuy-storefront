<?php

namespace App\Imports;

use App\Models\DeliveryZones;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class DeliveryZoneImport implements ToModel, WithHeadingRow
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        return new DeliveryZones([
            'name' => \str_slug($row['name']),
        ]);
    }
}
