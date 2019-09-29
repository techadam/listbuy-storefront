<?php

namespace App\Imports;

use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\OnEachRow;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Row;

class DeliveryZoneTariffImport implements WithHeadingRow, OnEachRow
{

    public function onRow(Row $row)
    {
        $row = $row->toArray();
        $model['sending_state_code'] = \strtolower($row['codes']);
        $all = [];
        foreach ($row as $key => $value) {
            if ($value == $model['sending_state_code'] || $value == null || $key == "codes") {
                continue;
            }
            $model['receiving_state_code'] = \strtolower($key);
            $model['delivery_zone_id'] = (int) $value;
            $model['created_at'] = Carbon::now();
            $model['updated_at'] = Carbon::now();
            array_push($all, $model);
        }
        return DB::table('delivery_zone_tariffs')->insert($all);

    }

}
