<?php

namespace Database\Seeders;

use App\Models\ShippingRoute;
use Illuminate\Database\Seeder;

class ShippingRouteSeeder extends Seeder
{
    public function run(): void
    {
        $routes = [
            // HUB
            ['name' => 'Patimban', 'country' => 'Indonesia', 'region' => 'Southeast Asia', 'category' => 'hub', 'latitude' => -6.23, 'longitude' => 107.85, 'color' => '#EC2029', 'flag' => '🇮🇩', 'description' => 'PICT Home Port', 'transit_days' => 0, 'sort_order' => 0],

            // DOMESTIC
            ['name' => 'Pontianak', 'country' => 'Indonesia', 'region' => 'Southeast Asia', 'category' => 'domestic', 'latitude' => -0.02, 'longitude' => 109.34, 'color' => '#0EA5E9', 'flag' => '🇮🇩', 'description' => 'West Kalimantan Feeder', 'transit_days' => 2, 'sort_order' => 1],
            ['name' => 'Batam', 'country' => 'Indonesia', 'region' => 'Southeast Asia', 'category' => 'domestic', 'latitude' => 1.13, 'longitude' => 104.05, 'color' => '#0EA5E9', 'flag' => '🇮🇩', 'description' => 'Riau Islands Hub', 'transit_days' => 1, 'sort_order' => 2],
            ['name' => 'Banjarmasin', 'country' => 'Indonesia', 'region' => 'Southeast Asia', 'category' => 'domestic', 'latitude' => -3.32, 'longitude' => 114.59, 'color' => '#0EA5E9', 'flag' => '🇮🇩', 'description' => 'South Kalimantan Port', 'transit_days' => 3, 'sort_order' => 3],
            ['name' => 'Makassar', 'country' => 'Indonesia', 'region' => 'Southeast Asia', 'category' => 'domestic', 'latitude' => -5.14, 'longitude' => 119.42, 'color' => '#0EA5E9', 'flag' => '🇮🇩', 'description' => 'Eastern Indonesia Hub', 'transit_days' => 4, 'sort_order' => 4],
            ['name' => 'Belawan', 'country' => 'Indonesia', 'region' => 'Southeast Asia', 'category' => 'domestic', 'latitude' => 3.78, 'longitude' => 98.68, 'color' => '#0EA5E9', 'flag' => '🇮🇩', 'description' => 'North Sumatra Port', 'transit_days' => 3, 'sort_order' => 5],

            // INTERNATIONAL
            ['name' => 'Port Klang', 'country' => 'Malaysia', 'region' => 'Southeast Asia', 'category' => 'international', 'latitude' => 3.00, 'longitude' => 101.40, 'color' => '#F59E0B', 'flag' => '🇲🇾', 'description' => 'Malaysia Main Hub', 'transit_days' => 3, 'sort_order' => 10],
            ['name' => 'Laem Chabang', 'country' => 'Thailand', 'region' => 'Southeast Asia', 'category' => 'international', 'latitude' => 13.08, 'longitude' => 100.88, 'color' => '#F59E0B', 'flag' => '🇹🇭', 'description' => 'Thailand Deep Sea Port', 'transit_days' => 4, 'sort_order' => 11],
            ['name' => 'Singapore', 'country' => 'Singapore', 'region' => 'Southeast Asia', 'category' => 'international', 'latitude' => 1.35, 'longitude' => 103.82, 'color' => '#F59E0B', 'flag' => '🇸🇬', 'description' => 'Global Transshipment Hub', 'transit_days' => 2, 'sort_order' => 12],
            ['name' => 'Manila', 'country' => 'Philippines', 'region' => 'Southeast Asia', 'category' => 'international', 'latitude' => 14.60, 'longitude' => 120.98, 'color' => '#F59E0B', 'flag' => '🇵🇭', 'description' => 'Philippines Port', 'transit_days' => 5, 'sort_order' => 13],
            ['name' => 'Nagoya', 'country' => 'Japan', 'region' => 'East Asia', 'category' => 'international', 'latitude' => 35.18, 'longitude' => 136.91, 'color' => '#F59E0B', 'flag' => '🇯🇵', 'description' => 'Japan Automotive Hub', 'transit_days' => 7, 'sort_order' => 14],
            ['name' => 'Yokohama', 'country' => 'Japan', 'region' => 'East Asia', 'category' => 'international', 'latitude' => 35.44, 'longitude' => 139.64, 'color' => '#F59E0B', 'flag' => '🇯🇵', 'description' => 'Japan Port', 'transit_days' => 7, 'sort_order' => 15],
            ['name' => 'Osaka', 'country' => 'Japan', 'region' => 'East Asia', 'category' => 'international', 'latitude' => 34.65, 'longitude' => 135.43, 'color' => '#F59E0B', 'flag' => '🇯🇵', 'description' => 'Japan Port', 'transit_days' => 7, 'sort_order' => 16],
            ['name' => 'Shanghai', 'country' => 'China', 'region' => 'East Asia', 'category' => 'international', 'latitude' => 31.23, 'longitude' => 121.47, 'color' => '#F59E0B', 'flag' => '🇨🇳', 'description' => 'China Main Port', 'transit_days' => 6, 'sort_order' => 17],
            ['name' => 'Hong Kong', 'country' => 'China', 'region' => 'East Asia', 'category' => 'international', 'latitude' => 22.30, 'longitude' => 114.17, 'color' => '#F59E0B', 'flag' => '🇭🇰', 'description' => 'Hong Kong Port', 'transit_days' => 5, 'sort_order' => 18],
            ['name' => 'Busan', 'country' => 'South Korea', 'region' => 'East Asia', 'category' => 'international', 'latitude' => 35.10, 'longitude' => 129.04, 'color' => '#F59E0B', 'flag' => '🇰🇷', 'description' => 'Korea Port', 'transit_days' => 8, 'sort_order' => 19],
            ['name' => 'Sydney', 'country' => 'Australia', 'region' => 'Oceania', 'category' => 'international', 'latitude' => -33.87, 'longitude' => 151.21, 'color' => '#F59E0B', 'flag' => '🇦🇺', 'description' => 'Australia Port', 'transit_days' => 12, 'sort_order' => 20],
            ['name' => 'Manzanillo', 'country' => 'Mexico', 'region' => 'Latin America', 'category' => 'international', 'latitude' => 19.05, 'longitude' => -104.31, 'color' => '#F59E0B', 'flag' => '🇲🇽', 'description' => 'Mexico Pacific Port', 'transit_days' => 25, 'sort_order' => 21],
            ['name' => 'Santos', 'country' => 'Brazil', 'region' => 'Latin America', 'category' => 'international', 'latitude' => -23.96, 'longitude' => -46.33, 'color' => '#F59E0B', 'flag' => '🇧🇷', 'description' => 'Brazil Main Port', 'transit_days' => 30, 'sort_order' => 22],
        ];

        foreach ($routes as $route) {
            ShippingRoute::create($route);
        }
    }
}