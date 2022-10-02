<?php

namespace App\Models;

use App\Carriers\Carrier;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Shipment extends Model
{
    use HasFactory;

    protected $guarded = [];

    /**
     * Boot the class and set the uuid on create.
     */
    protected static function boot(): void
    {
        parent::boot();

        static::creating(function (self $model): void {
            if (empty($model->uuid)) {
                $model->uuid = Str::uuid();
            }
        });
    }

    public static function makeShipment(Carrier $carrier)
    {

    }

}
