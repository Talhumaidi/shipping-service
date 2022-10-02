<?php

namespace App\Carriers;

use App\DTO\CarrierPayloadDto;

interface Carrier
{
    function __construct(CarrierPayloadDto $carrierPayloadDto);

    function validatePayload();

    function translatePayload(): array;

    function ship(array $payload): string;

    function getCarrierId(): string;
}
