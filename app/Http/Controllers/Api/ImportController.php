<?php

namespace App\Http\Controllers\Api;

use App\Models\States;
use App\Imports\StatesImport;
use App\Models\DeliveryZones;
use App\Models\DeliveryTariff;
use App\Models\DeliveryWeight;
use App\Models\DeliveryZoneTariff;
use App\Imports\DeliveryZoneImport;
use App\Http\Controllers\Controller;
use App\Http\Requests\ImportRequest;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\DeliveryTariffImport;
use App\Imports\DeliveryWeightImport;
use App\Imports\DeliveryZoneTariffImport;

class ImportController extends Controller
{
    public function importZoneTariff(ImportRequest $request)
    {
        Excel::import(new DeliveryZoneTariffImport, request()->file('file'));
        return $this->success(DeliveryZoneTariff::all());
    }

    public function importStates(ImportRequest $request)
    {
        Excel::import(new StatesImport, request()->file('file'));
        return $this->success(States::all());
    }

    public function importDeliveryWeight(ImportRequest $request)
    {
        Excel::import(new DeliveryWeightImport, request()->file('file'));
        return $this->success(DeliveryWeight::all());

    }

    public function importDeliveryZones(ImportRequest $request)
    {
        Excel::import(new DeliveryZoneImport, request()->file('file'));
        return $this->success(DeliveryZones::all());
    }

    public function importDeliveryTariffs(ImportRequest $request)
    {
        Excel::import(new DeliveryTariffImport, request()->file('file'));
        return $this->success(DeliveryTariff::all());
    }
}
