<?php

namespace Database\Seeders;

use App\Models\Component;
use App\Services\FilterComponentService;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ComponentSeed extends Seeder
{

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $components = FilterComponentService::all();

        foreach ( $components as $component ) {
            Component::factory()->create([
                'name'      => $component['name'],
                'json_body' => json_encode($component)
            ]);
        }
    }
}
