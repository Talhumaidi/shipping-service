<?php

namespace App\Carriers;

use App\DTO\CarrierPayloadDto;
use App\Helpers\UnitsOfMeasurement;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class FedexAir extends Carrier
{
    const CARRIER_ID = 'fedexAIR';
    const MAX_WIDTH_INCH = 12;
    const MAX_LENGTH_INCH = 18;
    const MAX_HEIGHT_INCH = 8;

    protected CarrierPayloadDto $carrierPayloadDto;

    public function __construct(CarrierPayloadDto $carrierPayloadDto)
    {
        $this->carrierPayloadDto = $carrierPayloadDto;
    }

    public function getCarrierId(): string
    {
        return self::CARRIER_ID;
    }

    public function translatePayload(): array
    {
        return [
            'carrierServiceID' => self::CARRIER_ID,
            'packageDetails' => [
                'width' => $this->carrierPayloadDto->getWidth(),
                'height' => $this->carrierPayloadDto->getHeight(),
                'length' => $this->carrierPayloadDto->getLength(),
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
