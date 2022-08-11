<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

/**
 * Class LocationRoomSeeder
 *
 * @package Database\Seeders
 */
class LocationRoomSeeder extends Seeder
{
    /**
     * @var string $table
     */
    static protected string $table = 'location_room';

    /**
     * @var array $tableData
     */
    static protected array $tableData = [
        [
            'name' => 'First',
            'temperature' => -15
        ],
        [
            'name' => 'Second',
            'temperature' => -10
        ],
        [
            'name' => 'Third',
            'temperature' => -5
        ]
    ];

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        $locations = DB::table(LocationSeeder::getTable())->get();
        $locations->each(static function ($location) {
            foreach (self::$tableData as $item) {
                $item['location_id'] = $location->id;
                DB::table(self::getTable())->insert($item);
            }
        });
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
