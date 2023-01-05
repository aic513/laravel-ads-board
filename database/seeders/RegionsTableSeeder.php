<?php

namespace Database\Seeders;

use App\Models\Region;
use Exception;
use Illuminate\Database\Seeder;

class RegionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     * @throws Exception
     */
    public function run()
    {
        Region::factory(10)->create()
            ->each(fn(Region $region) => $region->children()
                ->saveMany(Region::factory(random_int(3, 10))->create()
                    ->each(static fn(Region $region) => $region->children()
                        ->saveMany(Region::factory(random_int(3, 10))->make()
                        )
                    )
                )
            );
    }
}
