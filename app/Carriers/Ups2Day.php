<?php

namespace App\Carriers;

use App\DTO\CarrierPayloadDto;
use App\Helpers\UnitsOfMeasurement;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class Ups2Day extends Carrier
{
    const CARRIER_ID = 'UPS2DAY';
    const MAX_WIDTH_INCH = 12;
    const MAX_LENGTH_INCH = 18;
    const MAX_HEIGHT_INCH = 8;

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

    public function validationRules(): array
    {
        return [
            'width' => 'required|numeric|max:' . UnitsOfMeasurement::fromInch2Cm(self::MAX_WIDTH_INCH),
            'height' => 'required|numeric|max:' . UnitsOfMeasurement::fromInch2Cm(self::MAX_HEIGHT_INCH),
            'length' => 'required|numeric|max:' . UnitsOfMeasurement::fromInch2Cm(self::MAX_LENGTH_INCH),
        ];
    }
}
