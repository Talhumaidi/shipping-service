<?php

namespace App\Carriers;

use App\DTO\CarrierPayloadDto;
use App\Helpers\UnitsOfMeasurement;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class FedexGroud implements Carrier
{
    const CARRIER_ID = 'fedexGroud';
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

    public function ship(): string
    {
        $this->validate();
        $payload = $this->translatePayload();

        // Make API call
        return Str::uuid(); // some random string
    }

    public function translatePayload(): array
    {
        return [
            'carrierServiceID' => self::CARRIER_ID,
            'packageDetails' => [
                'width' => $this->carrierPayloadDto->getWidth(),
                'height' => $this->carrierPayloadDto->getHeight(),
                'length' => $this->carrierPayloadDto->getLength()
            ]
        ];
    }

    public function validate()
    {
        Validator::validate([
            'width' => UnitsOfMeasurement::fromCm2Inch($this->carrierPayloadDto->getWidth()),
            'height' => UnitsOfMeasurement::fromCm2Inch($this->carrierPayloadDto->getHeight()),
            'length' => UnitsOfMeasurement::fromCm2Inch($this->carrierPayloadDto->getLength())
        ],
            [
                'width' => 'required|numeric|max:' . self::MAX_WIDTH_INCH,
                'height' => 'required|numeric|max:' . self::MAX_HEIGHT_INCH,
                'length' => 'required|numeric|max:' . self::MAX_LENGTH_INCH,
            ],
            [
                'width.max' => sprintf("The width may not be greater than %0.2f cm",
                    UnitsOfMeasurement::fromInch2Cm(self::MAX_WIDTH_INCH)),
                'height.max' => sprintf("The height may not be greater than %0.2f cm",
                    UnitsOfMeasurement::fromInch2Cm(self::MAX_HEIGHT_INCH)),
                'length.max' => sprintf("The length may not be greater than %0.2f cm",
                    UnitsOfMeasurement::fromInch2Cm(self::MAX_LENGTH_INCH)),
            ]
        );
    }
}
