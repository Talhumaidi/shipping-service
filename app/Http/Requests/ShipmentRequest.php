<?php

namespace App\Http\Requests;

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
}
