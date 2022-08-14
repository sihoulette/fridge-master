<?php

namespace App\Helpers;

/**
 * Class FigureHelper
 *
 * @package App\Helpers
 */
class FigureHelper
{
    /**
     * @param float|int $height
     * @param float|int $length
     * @param float|int $width
     * @param int       $precision
     *
     * @return float
     * @author sihoullete
     */
    static public function getCuboidVolume(float|int $height, float|int $length, float|int $width, int $precision = 2): float
    {
        $volume = $height * $length * $width;

        return round((float)$volume, $precision);
    }
}
