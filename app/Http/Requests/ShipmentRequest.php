<?php

namespace App\Http\Requests;

use App\Carriers\Carrier;
use App\Carriers\CarrierResolver;
use App\DTO\CarrierPayloadDto;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Validator;

class ShipmentRequest extends FormRequest
{
    protected ?Carrier $carrier;

    public function rules(): array
    {
        return array_merge([
            'carrier_id' => 'required|string|in:' . implode(',', array_keys(CarrierResolver::carriersIdsMapping()))
        ], optional($this->carrier())->validationRules() ?: []
        );
    }

    public function carrier(): ?Carrier
    {
        if (! isset($this->carrier)) {
            $this->carrier = (new CarrierResolver($this->input('carrier_id')))
                ->resolve(
                    (new CarrierPayloadDto())
                        ->setHeight($this->input('height'))
                        ->setLength($this->input('length'))
                        ->setWidth($this->input('width'))
                );
        }
        return $this->carrier;
    }
}
