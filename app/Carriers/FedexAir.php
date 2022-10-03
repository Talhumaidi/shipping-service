<?php

namespace App\Carriers;

use App\DTO\CarrierPayloadDto;
use App\Helpers\UnitsOfMeasurement;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class FedexAir extends Carrier
{
    const CARRIER_ID = 'fedexAIR';

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
}
