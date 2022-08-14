<?php

namespace App\Http\Resources\Location;

use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Class StatLocationsResource
 *
 * @package App\Http\Resources\Location
 */
class StatLocationsResource extends JsonResource
{
    /**
     * @param $request
     *
     * @return array
     * @author sihoullete
     */
    public function with($request): array
    {
        $totalCount = $this->resource->count();
        $this->with['success'] = $totalCount > 0;
        $this->with['total_count'] = $totalCount;

        return parent::with($request);
    }
}
