<?php

namespace App\Http\Controllers;

use App\Http\Requests\RouteRequest;
use App\Services\RouteService;
use Illuminate\Http\Request;

class RouteController extends Controller
{
    protected $routeService;

    public function __construct(RouteService $routeService)
    {
        $this->routeService = $routeService;
    }

    /**
     * Calculate the optimal route based on the given location.
     */
    public function calculateRoute(RouteRequest $request)
    {
        $route = $this->routeService->calculateRoute($request->latitude, $request->longitude);

        return $this->success($route, "Route calculated successfully");
    }
}
