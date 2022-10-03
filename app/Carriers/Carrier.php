<?php

namespace App\Carriers;

use App\DTO\CarrierPayloadDto;
use App\Helpers\UnitsOfMeasurement;
use Illuminate\Support\Str;

abstract class Carrier
{
    const MAX_WIDTH_INCH = 12;
    const MAX_LENGTH_INCH = 18;
    const MAX_HEIGHT_INCH = 8;

    protected CarrierPayloadDto $carrierPayloadDto;

    public function __construct(CarrierPayloadDto $carrierPayloadDto)
    {
        $this->carrierPayloadDto = $carrierPayloadDto;
    }

    abstract function translatePayload(): array;

    abstract function getCarrierId(): string;

    public function ship(): string
    {
        $payload = $this->translatePayload();

        // Some wrapper around the SDK to call
        // sth like $this->carrierSdk()->ship($payload)

        return Str::uuid();
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
