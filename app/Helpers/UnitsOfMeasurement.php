<?php

namespace App\Helpers;

class UnitsOfMeasurement
{
    public static function fromCm2Inch($cm)
    {
        return $cm / 2.54;
    }

    public static function fromInch2Cm($inch)
    {
        return $inch * 2.54;
    }
}
