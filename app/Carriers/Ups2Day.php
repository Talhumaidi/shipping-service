<?php

namespace App\Carriers;

use App\DTO\CarrierPayloadDto;
use App\Helpers\UnitsOfMeasurement;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class Ups2Day extends Carrier
{
    const CARRIER_ID = 'UPS2DAY';

    public function getCarrierId(): string
    {
        return self::CARRIER_ID;
    }

    public function translatePayload(): array
    {
        return [
            'shipmentServiceID' => self::CARRIER_ID,
            'package' => [
                'width' => UnitsOfMeasurement::fromCm2Inch($this->carrierPayloadDto->getWidth()),
                'height' => UnitsOfMeasurement::fromCm2Inch($this->carrierPayloadDto->getHeight()),
                'length' => UnitsOfMeasurement::fromCm2Inch($this->carrierPayloadDto->getLength())
            ]
        ];
    }
}
