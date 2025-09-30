<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log; // Untuk debugging

class CheckUserLocation
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        // Jika ini adalah request AJAX untuk mendapatkan token CSRF atau rute yang dikecualikan,
        // atau jika aplikasi berjalan di lingkungan lokal/testing, lewati middleware ini.
        // Sesuaikan kondisi ini sesuai kebutuhanmu.
        if (app()->environment('local', 'testing') || $request->is('geolocation-check')) {
            return $next($request);
        }

        // Ambil koordinat lokasi SMA 1 dari .env
        $schoolLat = env('GEO_LAT');
        $schoolLon = env('GEO_LON');
        $radiusTolerance = env('GEO_RADIUS'); // Dalam meter

        // Ambil koordinat pengguna dari sesi (akan kita simpan dari JavaScript)
        $userLat = $request->session()->get('user_latitude');
        $userLon = $request->session()->get('user_longitude');

        // Log untuk debugging
        Log::info("User Lat: $userLat, User Lon: $userLon | School Lat: $schoolLat, School Lon: $schoolLon | Radius: $radiusTolerance");

        // Jika koordinat pengguna belum ada di sesi (belum dikirim dari frontend)
        if (empty($userLat) || empty($userLon)) {
            // Tampilkan view yang meminta lokasi dan mengirimkannya ke server
            return response()->view('location_gate', ['_token' => csrf_token()]);
        }

        // Hitung jarak menggunakan Haversine Formula (copy dari jawaban sebelumnya)
        $distance = $this->haversineGreatCircleDistance(
            $schoolLat, $schoolLon,
            $userLat, $userLon
        );

        Log::info("Distance: $distance meters.");

        // Periksa apakah jarak dalam toleransi
        if ($distance <= $radiusTolerance) {
            // Lokasi valid, izinkan request dilanjutkan
            return $next($request);
        } else {
            // Lokasi tidak valid, tolak akses
            return response()->view('location_denied', ['distance' => round($distance), 'allowed_radius' => $radiusTolerance]);
        }
    }

    /**
     * Menghitung jarak antara dua titik koordinat menggunakan Haversine Formula.
     *
     * @param float $latitudeFrom
     * @param float $longitudeFrom
     * @param float $latitudeTo
     * @param float $longitudeTo
     * @param int $earthRadius Radius bumi dalam meter (default 6371000m)
     * @return float Jarak dalam meter
     */
    private function haversineGreatCircleDistance(
        $latitudeFrom, $longitudeFrom, $latitudeTo, $longitudeTo, $earthRadius = 6371000)
    {
        // Convert from degrees to radians
        $latFrom = deg2rad($latitudeFrom);
        $lonFrom = deg2rad($longitudeFrom);
        $latTo = deg2rad($latitudeTo);
        $lonTo = deg2rad($longitudeTo);

        $latDelta = $latTo - $latFrom;
        $lonDelta = $lonTo - $lonFrom;

        $angle = 2 * asin(sqrt(pow(sin($latDelta / 2), 2) +
            cos($latFrom) * cos($latTo) * pow(sin($lonDelta / 2), 2)));
        return $angle * $earthRadius;
    }
}