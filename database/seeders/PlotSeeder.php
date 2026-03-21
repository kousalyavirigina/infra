<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Plot;

class PlotSeeder extends Seeder
{
    public function run(): void
    {
        for ($i = 1; $i <= 66; $i++) {
            Plot::firstOrCreate(
                ['plot_no' => $i], // UNIQUE KEY
                [
                    'sq_yards'   => 160,
                    'gadhulu'    => 20,
                    'facing'     => 'East',
                    'road_width' => 30,
                    'status'     => 'available',
                ]
            );
        }
    }
}
