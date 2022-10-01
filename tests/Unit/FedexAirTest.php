<?php

namespace Tests\Unit;

use App\Carriers\FedexAir;
use App\DTO\CarrierPayloadDto;
use Tests\TestCase;

class FedexAirTest extends TestCase
{
    /** @test */
    public function it_can_translate_valid_carrier_dto_into_fedex_air_payload()
    {
        $carrier_payload_dto = (new CarrierPayloadDto())
            ->setWidth(5)
            ->setLength(5)
            ->setHeight(5);

        $this->assertEquals([
            'carrierServiceID' => FedexAir::CARRIER_ID,
            'packageDetails' => [
                'width' => $carrier_payload_dto->getWidth(),
                'height' => $carrier_payload_dto->getHeight(),
                'length' => $carrier_payload_dto->getLength(),
            ]
        ], (new FedexAir($carrier_payload_dto))->translatePayload());
    }
}