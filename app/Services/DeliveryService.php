<?php

namespace App\Service;

use App\Models\DeliveryTariff;
use App\Models\DeliveryWeight;
use App\Models\DeliveryZoneTariff;
use App\Models\States;

class DeliveryService
{
    public function getDeliveryPrice($data)
    {
        $zone_model = DeliveryZoneTariff::where([['sending_state_code', $data['fromState']], ['receiving_state_code', $data['toState']]])->firstOrFail(['delivery_zone_id']);
        $weight_model = DeliveryWeight::where('weight', '>=', round($data['weight'], 1))->firstOrFail();
        $tariff_model = DeliveryTariff::where([['delivery_weight_id', $weight_model->id], ['delivery_zone_id', $zone_model->delivery_zone_id]])->first('price');
        return $tariff_model;
    }

    public function getDeliveryStates()
    {
        $states = States::all();
        return $states;
    }
}
