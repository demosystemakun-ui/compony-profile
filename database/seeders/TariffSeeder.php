<?php

namespace Database\Seeders;

use App\Models\Tariff;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;

class TariffSeeder extends Seeder
{
    /**
     * Memindahkan 3 PDF lama dari public/assets/pdf ke storage/app/public/tariffs
     * sehingga langsung bisa dikelola dari admin.
     */
    public function run(): void
    {
        $rows = [
            ['tag' => 'Domestic',      'title' => 'Domestic Tariffs',      'description' => 'Standardized rates for inter-island domestic vehicle handling services.', 'icon' => 'building', 'file' => 'Domestic_Tariff_2026.pdf',      'sort_order' => 1],
            ['tag' => 'International', 'title' => 'International Tariffs', 'description' => 'Official fee structure for cross-border export and import services.',      'icon' => 'globe',    'file' => 'International_Tariff_2026.pdf', 'sort_order' => 2],
            ['tag' => 'Others',        'title' => 'Others Tariffs',        'description' => 'Official fee structure for other miscellaneous services.',                  'icon' => 'document', 'file' => 'Others_Tariff_2026.pdf',        'sort_order' => 3],
        ];

        foreach ($rows as $row) {
            $file   = $row['file'];
            $source = public_path('assets/pdf/' . $file);
            $path   = null;

            if (file_exists($source)) {
                $path = 'tariffs/' . $file;
                Storage::disk('public')->put($path, file_get_contents($source));
            }

            unset($row['file']);
            Tariff::updateOrCreate(['title' => $row['title']], $row + ['pdf_path' => $path]);
        }
    }
}