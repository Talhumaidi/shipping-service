<?php

namespace App\Carriers;

use App\DTO\CarrierPayloadDto;
use Illuminate\Support\Str;

abstract class Carrier
{
    protected CarrierPayloadDto $carrierPayloadDto;

    public function __construct(CarrierPayloadDto $carrierPayloadDto)
    {
        $this->carrierPayloadDto = $carrierPayloadDto;
    }

    abstract function validationRules(): array;

    abstract function translatePayload(): array;

    abstract function getCarrierId(): string;

    public function ship(): string
    {
        $payload = $this->translatePayload();

        // Some wrapper around the SDK to call
        // sth like $this->carrierSdk()->ship($payload)

        return Str::uuid();
    }
}
