<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Services\Location\StatLocationService;
use App\Http\Resources\Location\StatLocationResource;
use App\Http\Resources\Location\StatLocationsResource;

/**
 * Class StatLocationController
 *
 * @package App\Http\Controllers\Api\v1
 */
class StatLocationController extends Controller
{
    /**
     * @var StatLocationService $service
     */
    protected StatLocationService $service;

    /**
     * @param StatLocationService $service
     */
    public function __construct(StatLocationService $service)
    {
        $this->service = $service;
    }

    /**
     * List of all locations
     *
     * @return StatLocationsResource
     * @author sihoullete
     */
    public function all()
    {
        $data = $this->service->getAll();

        return StatLocationsResource::make($data);
    }

    /**
     * Statistic of one location
     *
     * @return StatLocationResource
     * @author sihoullete
     */
    public function one(int $id)
    {
        $data = $this->service->getOne($id);

        return StatLocationResource::make($data);
    }
}
