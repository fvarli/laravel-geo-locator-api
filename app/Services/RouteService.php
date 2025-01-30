<?php

namespace App\Services;
use App\Http\Resources\RouteResource;
use App\Models\Location;

class RouteService
{
    public function calculateRoute($latitude, $longitude)
    {
        $locations = Location::all();

        $locationsWithDistance = $locations->map(function ($location) use ($latitude, $longitude) {
            $location->distance = $this->haversineDistance(
                (float) $latitude, (float) $longitude,
                (float) $location->latitude, (float) $location->longitude
            );
            return $location;
        })->sortBy('distance')->values();
    
        return RouteResource::collection($locationsWithDistance);
    }

    private function haversineDistance($lat1, $lon1, $lat2, $lon2)
    {
        $earthRadius = 6371;

        $latFrom = deg2rad($lat1);
        $lonFrom = deg2rad($lon1);
        $latTo = deg2rad($lat2);
        $lonTo = deg2rad($lon2);

        $latDelta = $latTo - $latFrom;
        $lonDelta = $lonTo - $lonFrom;

        $angle = 2 * asin(sqrt(
            pow(sin($latDelta / 2), 2) +
            cos($latFrom) * cos($latTo) * pow(sin($lonDelta / 2), 2)
        ));

        return round($earthRadius * $angle, 2);
    }
}
