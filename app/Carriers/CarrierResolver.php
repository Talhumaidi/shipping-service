<?php

namespace App\Carriers;

use App\DTO\CarrierPayloadDto;

class CarrierResolver
{
    protected $carriersMapping = [
        'fedex_air' => FedexAir::class,
        'fedex_groud' => FedexGroud::class,
        'ups_express' => UpsExpress::class,
        'ups_2_day' => Ups2Day::class
    ];

    public function __construct(string $carrier_id)
    {
        $this->carrier_id = $carrier_id;
    }

    public function resolve(CarrierPayloadDto $carrierPayloadDto): Carrier
    {
        return new $this->carriersMapping[$this->carrier_id]($carrierPayloadDto);
    }
}
