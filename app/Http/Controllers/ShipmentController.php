<?php

namespace App\Http\Controllers;

use App\Actions\CreateShipmentAction;
use App\Http\Requests\ShipmentRequest;
use App\Http\Resources\ShipmentResource;

class ShipmentController extends Controller
{
    public function store(ShipmentRequest $request, CreateShipmentAction $createShipmentAction)
    {
        $shipment = $createShipmentAction->execute($request->carrier());

        return response([
            'message' => 'Your shipment request has been created successfully!',
            'data' => ShipmentResource::make($shipment)
        ], 201);
    }
}
