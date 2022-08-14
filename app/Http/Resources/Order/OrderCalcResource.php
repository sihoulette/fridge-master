<?php

namespace App\Http\Resources\Order;

use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Class OrderCalcResource
 *
 * @package App\Http\Resources\Order
 */
class OrderCalcResource extends JsonResource
{
    /**
     * @param $request
     *
     * @return array
     * @author sihoullete
     */
    public function with($request): array
    {
        $this->with['success'] = !empty($this->resource['uses_blocks'] ?? 0);

        return parent::with($request);
    }
}
