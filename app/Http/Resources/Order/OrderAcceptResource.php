<?php

namespace App\Http\Resources\Order;

use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Class OrderAcceptResource
 *
 * @package App\Http\Resources\Order
 */
class OrderAcceptResource extends JsonResource
{
    /**
     * @param $request
     *
     * @return array
     * @author sihoullete
     */
    public function with($request): array
    {
        $this->with['success'] = !empty($this->resource['access_code'] ?? false);

        return parent::with($request);
    }
}
