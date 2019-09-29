<?php

namespace App\Imports;

use App\Models\DeliveryWeight;
use App\Models\DeliveryZones;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\OnEachRow;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Imports\HeadingRowFormatter;
use Maatwebsite\Excel\Row;

class DeliveryTariffImport implements WithHeadingRow, OnEachRow
{
    public function __construct()
    {
        HeadingRowFormatter::extend('custom', function ($value) {
            return \str_slug($value);
        });

        HeadingRowFormatter::default('custom');
    }

    public function onRow(Row $row)
    {
        $row = $row->toArray();
        $weight = DeliveryWeight::where('weight', $row['weight'])->first();
        $all = [];
        $row = collect($row)->forget('weight');
        foreach ($row as $key => $value) {
            $model['delivery_zone_id'] = DeliveryZones::where('name', $key)->firstOrFail('id')['id'];
            $model['price'] = number_format($value,2);
            $model['created_at'] = Carbon::now();
            $model['updated_at'] = Carbon::now();
            array_push($all, $model);
        }
        return $weight->prices()->createMany($all);
    }
}
