<?php

namespace App\Http\Controllers;

use App\Carriers\Carrier;
use App\Carriers\CarrierResolver;
use App\DTO\CarrierPayloadDto;
use App\Http\Requests\ShipmentRequest;
use App\Http\Resources\ShipmentResource;
use App\Models\Shipment;

class ShipmentController extends Controller
{
    protected Carrier $carrier;
    protected CarrierPayloadDto $carrierPayloadDto;

    public function store(ShipmentRequest $request)
    {
        $this->carrierPayloadDto = (new CarrierPayloadDto())
            ->setHeight($request->input('package.height'))
            ->setLength($request->input('package.length'))
            ->setWidth($request->input('package.width'));

        $this->carrier = (new CarrierResolver($request->input('carrier_id')))
                ->resolve($this->carrierPayloadDto);

        $package_id = $this->carrier->ship();

        $shipment = Shipment::create([
            'carrier_id' => $this->carrier->getCarrierId(),
            'package_id' => $package_id
            // 'payload' => should we store the payload of the shipment creation request? it depends!
        ]);

        return response([
            'message' => 'Your shipment request has been created successfully!',
            'data' => ShipmentResource::make($shipment)
        ], 201);
    }
}
