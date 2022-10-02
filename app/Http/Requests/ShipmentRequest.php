<?php

namespace App\Http\Requests;

use App\Carriers\Carrier;
use App\Carriers\CarrierResolver;
use App\DTO\CarrierPayloadDto;
use Illuminate\Foundation\Http\FormRequest;

class ShipmentRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'carrier_id' => 'required|string|in:fedex_air,fedex_groud,ups_express,ups_2_day',
            'width' => ['required', 'numeric'],
            'length' => ['required', 'numeric'],
            'height' => ['required', 'numeric']
        ];
    }

    public function carrier(): Carrier
    {
        return (new CarrierResolver($this->input('carrier_id')))
            ->resolve(
                (new CarrierPayloadDto())
                    ->setHeight($this->input('height'))
                    ->setLength($this->input('length'))
                    ->setWidth($this->input('width'))
            );
    }
}
