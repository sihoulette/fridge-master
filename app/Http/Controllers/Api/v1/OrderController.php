<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Order\OrderCalcRequest;
use App\Http\Requests\Order\OrderAcceptRequest;
use App\Http\Resources\Order\OrderAcceptResource;
use App\Http\Resources\Order\OrderCalcResource;
use App\Services\Order\OrderService;

/**
 * Class OrderController
 *
 * @package App\Http\Controllers\Api\v1
 */
class OrderController extends Controller
{
    /**
     * @var OrderService $service
     */
    protected OrderService $service;

    /**
     * @param OrderService $service
     */
    public function __construct(OrderService $service)
    {
        $this->service = $service;
    }

    /**
     * Calculate order
     *
     * @param OrderCalcRequest $request
     *
     * @return OrderCalcResource
     * @author sihoullete
     */
    public function calc(OrderCalcRequest $request)
    {
        $data = $request->validated();
        $data = $this->service->calc($data);

        return OrderCalcResource::make($data);
    }

    /**
     * Accept calculated order
     *
     * @param OrderAcceptRequest $request
     *
     * @return OrderAcceptResource
     * @author sihoullete
     */
    public function accept(OrderAcceptRequest $request)
    {
        $data = $request->validated();

        $data = $this->service->accept($data);

        return OrderAcceptResource::make($data);
    }
}
