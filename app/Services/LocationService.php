<?php

namespace App\Services;

use App\Models\Location;

class LocationService {
    public function getAllLocations() {
        return Location::all();
    }

    public function getLocationById($id) {
        return Location::findOrFail($id);
    }

    public function createLocation($data) {
        return Location::create($data);
    }

    public function updateLocation($id, $data) {
        $location = Location::findOrFail($id);
        $location->update($data);
        return $location;
    }

    public function deleteLocation($id) {
        $location = Location::findOrFail($id);
        return $location->delete();
    }
}
