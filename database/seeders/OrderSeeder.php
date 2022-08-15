<?php

namespace Database\Seeders;

use Carbon\Carbon;
use App\Tools\RandomCode;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

/**
 * Class OrderSeeder
 *
 * @package Database\Seeders
 */
final class OrderSeeder extends Seeder
{
    /**
     * @var string $table
     */
    static protected string $table = 'order';

    /**
     * @var array $order
     */
    static protected array $order = [
        'temperature' => -5,
        'volume' => 20,
        'name' => 'Dev',
        'email' => 'aleksandr.bytsyk@gmail.com'
    ];

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $locations = DB::table(LocationSeeder::getTable())->get();
        $locations->each(static function ($location) {
            $orderRoom = DB::table(LocationRoomSeeder::getTable())
                ->where('location_id', $location->id)
                ->where('temperature', self::$order['temperature'])
                ->first();
            if ($orderRoom) {
                $canFillOrder = ! DB::table(self::getTable())
                    ->where('location_id', $orderRoom->location_id)
                    ->exists();
                if ($canFillOrder) {
                    DB::table(self::getTable())->insert([
                        'access_code' => RandomCode::uniqueInTable('order', 'access_code'),
                        'location_id' => $location->id,
                        'temperature' => self::$order['temperature'],
                        'volume' => self::$order['volume'],
                        'name' => self::$order['name'],
                        'email' => self::$order['email'],
                        'beginning_at' => Carbon::now()->format('Y-m-d H:i:s'),
                        'ending_at' => Carbon::now()->addDays(20)->format('Y-m-d H:i:s')
                    ]);
                }
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
