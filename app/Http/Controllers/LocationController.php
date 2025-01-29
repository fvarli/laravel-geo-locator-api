<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreLocationRequest;
use App\Http\Requests\UpdateLocationRequest;
use App\Services\LocationService;
use App\Traits\ApiResponse;

use Illuminate\Http\Request;

class LocationController extends Controller
{
    use ApiResponse;

    protected $locationService;

    public function __construct(LocationService $locationService) {
        $this->locationService = $locationService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $locations = $this->locationService->getAllLocations();
        return $this->success($locations);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreLocationRequest $request) {
        $location = $this->locationService->createLocation($request->validated());
        return $this->success($location, "Location added successfully", 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $location = $this->locationService->getLocationById($id);
        return $this->success($location);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateLocationRequest $request, string $id)
    {
        $location = $this->locationService->updateLocation($id, $request->validated());
        return $this->success($location, "Location updated successfully");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $this->locationService->deleteLocation($id);
        return $this->success(null, "Location deleted successfully");
    }
}
