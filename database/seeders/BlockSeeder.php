<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

/**
 * Class BlockSeeder
 *
 * @package Database\Seeders
 */
final class BlockSeeder extends Seeder
{
    /**
     * @var string $table
     */
    static protected string $table = 'block';

    /**
     * @var array $tableData
     */
    static protected array $tableData = [
        [
            'name' => 'Default',
            'length' => 2,
            'width' => 1,
            'height' => 1,
            'volume' => 2,
            'price' => 2,
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
