<?php

namespace App\Http\Requests;

use App\Carriers\Carrier;
use App\Carriers\CarrierResolver;
use App\DTO\CarrierPayloadDto;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Validator;

class ShipmentRequest extends FormRequest
{
    protected Carrier $carrier;

    public function rules(): array
    {
        return [
            'carrier_id' => 'required|string|in:fedex_air,fedex_groud,ups_express,ups_2_day',
            'width' => ['required', 'numeric'],
            'length' => ['required', 'numeric'],
            'height' => ['required', 'numeric']
        ];
    }

    /**
     * Configure the validator instance.
     *
     * @param  \Illuminate\Validation\Validator  $validator
     * @return void
     */
    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            if ($validator->failed()) {
                return;
            }
            \Illuminate\Support\Facades\Validator::make(...$this->carrier()->validationRules())
                ->validate();
        });
    }

    public function carrier(): Carrier
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
