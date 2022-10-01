<?php

namespace Tests\Unit;

use App\Carriers\UpsExpress;
use App\DTO\CarrierPayloadDto;
use App\Helpers\UnitsOfMeasurement;
use Tests\TestCase;

class UpsExpressTest extends TestCase
{

    /** @test */
    public function it_can_translate_valid_carrier_dto_into_ups_express_payload()
    {
        $carrier_payload_dto = (new CarrierPayloadDto())
            ->setWidth(5)
            ->setLength(5)
            ->setHeight(5);

        $this->assertEquals([
            'shipmentServiceID' => UpsExpress::CARRIER_ID,
            'package' => [
                'width' => UnitsOfMeasurement::fromCm2Inch($carrier_payload_dto->getWidth()),
                'height' => UnitsOfMeasurement::fromCm2Inch($carrier_payload_dto->getHeight()),
                'length' => UnitsOfMeasurement::fromCm2Inch($carrier_payload_dto->getLength()),
            ]
        ], (new UpsExpress($carrier_payload_dto))->translatePayload());
    }
}