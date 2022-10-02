<?php

namespace App\Actions;

use App\Carriers\Carrier;
use App\Models\Shipment;

class CreateShipmentAction
{
    public function execute(Carrier $carrier): Shipment
    {
        return Shipment::create([
            'carrier_id' => $carrier->getCarrierId(),
            'package_id' => $carrier->ship($carrier->translatePayload())
        ]);
    }

}
