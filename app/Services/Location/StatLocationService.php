<?php

namespace App\Services\Location;

use App\Models\Order\Order;
use App\Models\Block\Block;
use App\Models\Location\Location;
use App\Models\Location\LocationRoom;
use App\Models\Location\LocationRoomBlock;
use Illuminate\Support\Collection;
use App\Helpers\FigureHelper;

/**
 * Class StatLocationService
 *
 * @package App\Services\Location
 */
class StatLocationService
{
    /**
     * @return Collection
     * @author sihoullete
     */
    public function getAll(): Collection
    {
        $locations = Location::get(['id', 'name']);
        $locations->each(static function (Location $location) {
            self::fillStatAttributes($location);
        });

        return $locations;
    }

    /**
     * @param int|null $id
     *
     * @return Location|null
     * @author sihoullete
     */
    public function getOne(?int $id = null): ?Location
    {
        $location = Location::where('id', $id)
            ->first(['id', 'name']);
        if ($location instanceof Location) {
            $location = self::fillStatAttributes($location);
        }

        return $location;
    }

    /**
     * @param Location $model
     *
     * @return Location
     * @author sihoullete
     */
    static protected function fillStatAttributes(Location $model): Location
    {
        $totalBlocks = LocationRoomBlock::where('location_id', $model->id)
            ->sum('quantity');
        $model->setAttribute('total_blocks', (int)$totalBlocks);

        $orders = Order::where('location_id', $model->id)
            ->whereNotIn('status', ['out-delivery', 'complete', 'abort']);

        $usesBlocks = 0;
        $orders->each(static function (Order $order) use (&$usesBlocks) {
            $startTemp = min($order->temperature - LocationRoom::TEMPERATURE_OFFSET, 0);
            $endTemp = min($order->temperature + LocationRoom::TEMPERATURE_OFFSET, 0);
            $reservedRoom = LocationRoomBlock::leftJoin('location_room', 'location_room.id', '=', 'location_room_block.location_room_id')
                ->where('location_room.location_id', $order->location_id)
                ->whereIn('temperature', range($startTemp, $endTemp));

            $reservedRoom->each(static function (LocationRoomBlock $storage) use ($order, &$usesBlocks) {
                $storageBlock = Block::where('id', $storage->block_id)
                    ->first();
                if ($storageBlock instanceof Block) {
                    $blockVolume = !empty($storageBlock->volume)
                        ? $storageBlock->volume
                        : FigureHelper::getCuboidVolume($storageBlock->height, $storageBlock->length, $storageBlock->width);
                    $usesBlocks += round($order->volume / $blockVolume);
                }
            });
        });
        $model->setAttribute('free_blocks', $totalBlocks - $usesBlocks);

        return $model;
    }
}
