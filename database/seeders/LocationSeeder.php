<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

/**
 * Class LocationSeeder
 *
 * @package Database\Seeders
 */
final class LocationSeeder extends Seeder
{
    /**
     * @var string $table
     */
    static protected string $table = 'location';

    /**
     * @var array $tableData
     */
    static protected array $tableData = [
        [
            'name' => 'Уилмингтон (Северная Каролина)',
            'timezone' => 'America/New_York',
        ],
        [
            'name' => 'Портленд (Орегон)',
            'timezone' => 'America/Los_Angeles',
        ],
        [
            'name' => 'Торонто',
            'timezone' => 'America/Toronto',
        ],
        [
            'name' => 'Варшава',
            'timezone' => 'Europe/Warsaw',
        ],
        [
            'name' => 'Валенсия',
            'timezone' => 'Europe/Madrid',
        ],
        [
            'name' => 'Шанхай',
            'timezone' => 'Asia/Shanghai',
        ]
    ];

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        foreach (self::$tableData as $item) {
            DB::table(self::getTable())->insert($item);
        }
    }

    /**
     * @return string
     * @author sihoullete
     */
    static public function getTable(): string
    {
        return self::$table;
    }
}
