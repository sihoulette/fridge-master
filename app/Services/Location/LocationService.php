<?php

namespace App\Services\Location;

use App\Models\Order\Order;
use App\Models\Block\Block;
use App\Models\Location\LocationRoom;
use App\Models\Location\LocationRoomBlock;
use Illuminate\Support\Collection;
use App\Helpers\FigureHelper;

/**
 * Class LocationService
 *
 * @package App\Services\Location
 */
class LocationService
{
    /**
     * @param int $locationID
     *
     * @return Collection
     * @author sihoullete
     */
    static public function roomsState(int $locationID): Collection
    {
        $locationRooms = LocationRoomBlock::leftJoin('location_room', 'location_room.id', '=', 'location_room_block.location_room_id')
            ->where('location_room.location_id', $locationID)
            ->get([
                'location_room_block.block_id AS block_id',
                'location_room.location_id AS location_id',
                'location_room.id AS room_id',
                'location_room.temperature AS temperature',
                'location_room_block.quantity AS total_blocks',
            ]);

        $notInOrders = [];
        $locationRooms->each(static function ($room) use (&$notInOrders) {
            // Calc room total blocks volume
            $blockVolume = 0;
            $storageBlock = Block::where('id', $room->block_id)
                ->first();
            if ($storageBlock instanceof Block) {
                $blockVolume = !empty($storageBlock->volume)
                    ? $storageBlock->volume
                    : FigureHelper::getCuboidVolume($storageBlock->height, $storageBlock->length, $storageBlock->width);
            }
            $room->setAttribute('total_volume', $room->total_blocks * $blockVolume);

            // Find uses location volume in orders
            $startTemp = min($room->temperature - LocationRoom::TEMPERATURE_OFFSET, 0);
            $endTemp = min($room->temperature + LocationRoom::TEMPERATURE_OFFSET, 0);

            $orders = Order::where('location_id', $room->location_id)
                ->whereNotIn('id', $notInOrders)
                ->whereIn('temperature', range($startTemp, $endTemp))
                ->whereNotIn('status', ['out-delivery', 'complete', 'abort']);

            // Write checked orders volume
            $orders->each(static function (Order $order) use (&$notInOrders) {
                $notInOrders[$order->id] = $order->id;
            });

            // Write free room volume
            $ordersVolume = $orders->sum('volume');

            $freeVolume = $room->total_volume - $ordersVolume;
            $room->setAttribute('free_volume', $freeVolume);
        });

        return $locationRooms;
    }
}
