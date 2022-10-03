<?php

namespace Tests\Feature;

use App\Carriers\Carrier;
use App\Carriers\FedexAir;
use App\Carriers\FedexGroud;
use App\Carriers\Ups2Day;
use App\Carriers\UpsExpress;
use App\Helpers\UnitsOfMeasurement;
use App\Models\Shipment;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Validation\ValidationException;
use Tests\TestCase;

class ShipmentControllerTest extends TestCase
{
    use DatabaseMigrations;

    public function setUp(): void
    {
        parent::setUp();
        $this->withoutExceptionHandling();
    }

    /** @test */
    public function it_can_create_ups_express_shipment()
    {
        $this->post('/api/shipment', [
            'carrier_id' => 'ups_express',
            'width' => 5,
            'length' => 5,
            'height' => 5
        ]);

        $this->assertEquals(Shipment::first()->carrier_id, UpsExpress::CARRIER_ID);
    }

    /** @test */
    public function it_can_create_ups_2_day_shipment()
    {
        $this->post('/api/shipment', [
            'carrier_id' => 'ups_2_day',
            'width' => 5,
            'length' => 5,
            'height' => 5
        ]);

        $this->assertEquals(Shipment::first()->carrier_id, Ups2Day::CARRIER_ID);
    }

    /** @test */
    public function it_can_create_fedex_air_shipment()
    {
        $this->post('/api/shipment', [
            'carrier_id' => 'fedex_air',
            'width' => 5,
            'length' => 5,
            'height' => 5
        ]);

        $this->assertEquals(Shipment::first()->carrier_id, FedexAir::CARRIER_ID);
    }

    /** @test */
    public function it_can_create_fedex_groud_shipment()
    {
        $this->post('/api/shipment', [
            'carrier_id' => 'fedex_groud',
            'width' => 5,
            'length' => 5,
            'height' => 5
        ]);

        $this->assertEquals(Shipment::first()->carrier_id, FedexGroud::CARRIER_ID);
    }

    /** @test */
    public function it_can_validate_if_wrong_carrier_id_is_sent()
    {
        $this->expectException(ValidationException::class);

        $this->post('/api/shipment', [
            'carrier_id' => 'wrong_carrier_id',
            'width' => 5,
            'length' => 5,
            'height' => 5
        ]);
    }

    /** @test */
    public function it_can_validate_if_ups_express_dimensions_are_oversize()
    {
        $this->expectException(ValidationException::class);

        $this->post('/api/shipment', [
            'carrier_id' => 'ups_express',
            'width' => UnitsOfMeasurement::fromInch2Cm(Carrier::MAX_WIDTH_INCH) + 1,
            'length' => UnitsOfMeasurement::fromInch2Cm(Carrier::MAX_LENGTH_INCH),
            'height' => UnitsOfMeasurement::fromInch2Cm(Carrier::MAX_HEIGHT_INCH),
        ]);
    }

    /** @test */
    public function it_can_validate_if_ups_2_day_dimensions_are_oversize()
    {
        $this->expectException(ValidationException::class);

        $this->post('/api/shipment', [
            'carrier_id' => 'ups_2_day',
            'width' => UnitsOfMeasurement::fromInch2Cm(Carrier::MAX_WIDTH_INCH),
            'length' => UnitsOfMeasurement::fromInch2Cm(Carrier::MAX_LENGTH_INCH),
            'height' => UnitsOfMeasurement::fromInch2Cm(Carrier::MAX_HEIGHT_INCH) + 5,
        ]);
    }

    /** @test */
    public function it_can_validate_if_fedex_air_dimensions_are_oversize()
    {
        $this->expectException(ValidationException::class);

        $this->post('/api/shipment', [
            'carrier_id' => 'fedex_air',
            'width' => UnitsOfMeasurement::fromInch2Cm(Carrier::MAX_WIDTH_INCH),
            'length' => UnitsOfMeasurement::fromInch2Cm(Carrier::MAX_LENGTH_INCH),
            'height' => UnitsOfMeasurement::fromInch2Cm(Carrier::MAX_HEIGHT_INCH) + 1,
        ]);
    }
}
