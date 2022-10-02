<?php

namespace App\Http\Controllers;

use App\Http\Requests\ShipmentRequest;
use App\Http\Resources\ShipmentResource;
use App\Models\Shipment;

class ShipmentController extends Controller
{
    public function store(ShipmentRequest $request)
    {
        return response([
            'message' => 'Your shipment request has been created successfully!',
            'data' => ShipmentResource::make(Shipment::makeShipment($request->carrier()))
        ], 201);
    }
}
