<?php

namespace App\Carriers;

use App\DTO\CarrierPayloadDto;
use App\Helpers\UnitsOfMeasurement;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class UpsExpress implements Carrier
{
    const CARRIER_ID = 'UPSExpress';
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

    public function ship(array $payload): string
    {
        // Make API call
        return Str::uuid(); // some random string
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
            [
                'width' => UnitsOfMeasurement::fromCm2Inch($this->carrierPayloadDto->getWidth()),
                'height' => UnitsOfMeasurement::fromCm2Inch($this->carrierPayloadDto->getHeight()),
                'length' => UnitsOfMeasurement::fromCm2Inch($this->carrierPayloadDto->getLength())
            ],
            [
                'width' => 'numeric|max:' . self::MAX_WIDTH_INCH,
                'height' => 'numeric|max:' . self::MAX_HEIGHT_INCH,
                'length' => 'numeric|max:' . self::MAX_LENGTH_INCH,
            ],
            [
                'width.max' => sprintf("The width may not be greater than %0.2f cm",
                    UnitsOfMeasurement::fromInch2Cm(self::MAX_WIDTH_INCH)),
                'height.max' => sprintf("The height may not be greater than %0.2f cm",
                    UnitsOfMeasurement::fromInch2Cm(self::MAX_HEIGHT_INCH)),
                'length.max' => sprintf("The length may not be greater than %0.2f cm",
                    UnitsOfMeasurement::fromInch2Cm(self::MAX_LENGTH_INCH)),
            ]
        ];
    }


}
