<?php

namespace App\Carriers;

use App\DTO\CarrierPayloadDto;

class CarrierResolver
{
    public function __construct(?string $carrier_id)
    {
        $this->carrier_id = $carrier_id;
    }

    public static function carriersIdsMapping(): array
    {
        return [
            'fedex_air' => FedexAir::class,
            'fedex_groud' => FedexGroud::class,
            'ups_express' => UpsExpress::class,
            'ups_2_day' => Ups2Day::class
        ];
    }

    public function resolve(CarrierPayloadDto $carrierPayloadDto): ?Carrier
    {
        $carriersIdsMapping = self::carriersIdsMapping();

        if (! $this->carrier_id || ! isset($carriersIdsMapping[$this->carrier_id])) {
            return null;
        }

        return new $carriersIdsMapping[$this->carrier_id]($carrierPayloadDto);
    }
}
