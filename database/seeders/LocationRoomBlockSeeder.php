<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

/**
 * Class LocationRoomBlockSeeder
 *
 * @package Database\Seeders
 */
final class LocationRoomBlockSeeder extends Seeder
{
    /**
     * @var string $table
     */
    static protected string $table = 'location_room_block';

    /**
     * @var int $blockCount
     */
    static protected int $blockCount = 10;

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        $blocks = DB::table(BlockSeeder::getTable())->get();
        $rooms = DB::table(LocationRoomSeeder::getTable())->get();
        $rooms->each(static function ($room) use ($blocks) {
            $blocks->each(static function ($block) use ($room) {
                $data['block_id'] = $block->id;
                $data['location_id'] = $room->location_id;
                $data['location_room_id'] = $room->id;
                $data['quantity'] = self::$blockCount;
                DB::table(self::getTable())->insert($data);
            });
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
