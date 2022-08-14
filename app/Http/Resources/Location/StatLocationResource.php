<?php

namespace App\Http\Resources\Location;

use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Class StatLocationResource
 *
 * @package App\Http\Resources\Location
 */
class StatLocationResource extends JsonResource
{
    /**
     * @param $request
     *
     * @return array
     * @author sihoullete
     */
    public function with($request): array
    {
        $this->with['success'] = !empty($this->resource);

        return parent::with($request);
    }
}
