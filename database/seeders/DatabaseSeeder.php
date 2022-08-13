<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

/**
 * Class DatabaseSeeder
 *
 * @package Database\Seeders
 */
final class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(BlockSeeder::class);
        $this->call(LocationSeeder::class);
        $this->call(LocationRoomSeeder::class);
        $this->call(LocationRoomBlockSeeder::class);
        $this->call(OrderSeeder::class);
    }
}
