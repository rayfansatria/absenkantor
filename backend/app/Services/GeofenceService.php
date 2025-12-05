<?php

namespace App\Services;

use App\Models\AttendanceLocation;

class GeofenceService
{
    /**
     * Calculate distance between two coordinates using Haversine formula
     * 
     * @param float $lat1 Latitude of point 1
     * @param float $lon1 Longitude of point 1
     * @param float $lat2 Latitude of point 2
     * @param float $lon2 Longitude of point 2
     * @return float Distance in meters
     */
    public function calculateDistance($lat1, $lon1, $lat2, $lon2): float
    {
        $earthRadius = 6371000; // Earth's radius in meters

        $latFrom = deg2rad($lat1);
        $lonFrom = deg2rad($lon1);
        $latTo = deg2rad($lat2);
        $lonTo = deg2rad($lon2);

        $latDelta = $latTo - $latFrom;
        $lonDelta = $lonTo - $lonFrom;

        $a = sin($latDelta / 2) * sin($latDelta / 2) +
             cos($latFrom) * cos($latTo) *
             sin($lonDelta / 2) * sin($lonDelta / 2);
        
        $c = 2 * atan2(sqrt($a), sqrt(1 - $a));

        return $earthRadius * $c;
    }

    /**
     * Check if coordinates are within any valid attendance location
     * 
     * @param int $institutionId Institution ID
     * @param float $latitude User's latitude
     * @param float $longitude User's longitude
     * @return array|null Returns location data if within range, null otherwise
     */
    public function isWithinValidLocation($institutionId, $latitude, $longitude): ?array
    {
        $locations = AttendanceLocation::where('institution_id', $institutionId)
            ->where('is_active', true)
            ->get();

        foreach ($locations as $location) {
            $distance = $this->calculateDistance(
                $latitude,
                $longitude,
                $location->latitude,
                $location->longitude
            );

            if ($distance <= $location->radius) {
                return [
                    'location' => $location,
                    'distance' => round($distance, 2)
                ];
            }
        }

        return null;
    }

    /**
     * Validate coordinates are within specific location
     * 
     * @param int $locationId Attendance location ID
     * @param float $latitude User's latitude
     * @param float $longitude User's longitude
     * @return array Validation result with status and distance
     */
    public function validateLocation($locationId, $latitude, $longitude): array
    {
        $location = AttendanceLocation::find($locationId);

        if (!$location || !$location->is_active) {
            return [
                'valid' => false,
                'message' => 'Lokasi absensi tidak valid',
                'distance' => null
            ];
        }

        $distance = $this->calculateDistance(
            $latitude,
            $longitude,
            $location->latitude,
            $location->longitude
        );

        if ($distance <= $location->radius) {
            return [
                'valid' => true,
                'message' => 'Anda berada dalam radius absensi',
                'distance' => round($distance, 2),
                'location' => $location
            ];
        }

        return [
            'valid' => false,
            'message' => 'Anda berada di luar radius absensi',
            'distance' => round($distance, 2),
            'required_distance' => $location->radius
        ];
    }
}
