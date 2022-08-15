<?php

namespace App\Services\Order;

use App\Models\Block\Block;
use App\Models\Order\Order;
use App\Models\Location\LocationRoom;
use App\Services\Location\LocationService;
use Illuminate\Support\Facades\DB;
use App\Helpers\FigureHelper;
use App\Tools\RandomCode;
use Exception;

/**
 * Class OrderService
 *
 * @package App\Services\Order
 */
class OrderService
{
    /**
     * @param array $data
     *
     * @return array
     * @author sihoullete
     */
    public function calc(array $data = []): array
    {
        $resp = [
            'location_id' => (int)$data['location_id'],
            'uses_blocks' => 0,
        ];
        $roomsState = LocationService::roomsState((int)$data['location_id']);
        if (!empty($roomsState)) {
            // Need room temperature range to calc
            $startTemp = min($data['temperature'] - LocationRoom::TEMPERATURE_OFFSET, 0);
            $endTemp = min($data['temperature'] + LocationRoom::TEMPERATURE_OFFSET, 0);
            $tempRange = range($startTemp, $endTemp);
            // Need calc volume in rooms
            $needVolume = (int)$data['volume'];

            // Calculate uses blocks in rooms
            $roomsState->each(static function ($room) use ($tempRange, &$needVolume, &$resp) {
                if ($needVolume > 0 && in_array($room->temperature, $tempRange)) {
                    // Calculate one block volume
                    $blockVolume = 0;
                    $storageBlock = Block::where('id', $room->block_id)
                        ->first();
                    if ($storageBlock instanceof Block) {
                        $blockVolume = !empty($storageBlock->volume)
                            ? $storageBlock->volume
                            : FigureHelper::getCuboidVolume($storageBlock->height, $storageBlock->length, $storageBlock->width);
                    }

                    // Calculate uses blocks
                    if ($room->free_volume >= $needVolume) {
                        $resp['uses_blocks'] = $needVolume / $blockVolume;
                        $needVolume = 0;
                    } else {
                        $resp['uses_blocks'] += $needVolume / $blockVolume;
                        $needVolume = $needVolume - $room->free_volume;
                    }
                }
            });
        }

        return $resp;
    }

    /**
     * @param array $data
     *
     * @return array
     * @author sihoullete
     */
    public function accept(array $data = []): array
    {
        $resp = $this->calc($data);
        if (!empty($resp['uses_blocks'])) {
            $data['access_code'] = RandomCode::uniqueInTable('order', 'access_code');
            DB::beginTransaction();
            try {
                Order::create($data);
                $resp['access_code'] = $data['access_code'];
                DB::commit();
            } catch (Exception $e) {
                DB::rollBack();
                //TODO log exception
            }
        }

        return $resp;
    }
}
