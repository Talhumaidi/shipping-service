<?php

namespace App\Carriers;

use App\DTO\CarrierPayloadDto;

interface Carrier
{
    function __construct(CarrierPayloadDto $carrierPayloadDto);

    function validate();

    function translatePayload(): array;

    function ship(): string;

    function getCarrierId(): string;
}
