<?php

namespace App\Tools;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

/**
 * Class RandomCode
 *
 * @package App\Tools
 */
class RandomCode
{
    /**
     * @param string $table
     * @param string $column
     * @param int    $length
     *
     * @return string
     * @author sihoullete
     */
    static public function uniqueInTable(string $table, string $column, int $length = 12): string
    {
        $random = Str::random($length);

        $recreate = DB::table($table)
            ->where($column, $random)->exists();
        if ($recreate) {
            $random = self::uniqueInTable($table, $column, $length);
        }

        return $random;
    }
}
