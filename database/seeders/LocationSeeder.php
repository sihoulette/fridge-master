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
        ],
        [
            'name' => 'Портленд (Орегон)',
        ],
        [
            'name' => 'Торонто',
        ],
        [
            'name' => 'Варшава',
        ],
        [
            'name' => 'Валенсия',
        ],
        [
            'name' => 'Шанхай',
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
