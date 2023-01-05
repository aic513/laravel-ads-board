<?php

namespace Database\Seeders;

use App\Models\Adverts\Category;
use Exception;
use Illuminate\Database\Seeder;

class AdvertCategoriesTableSeeder extends Seeder
{
    /**
     * @throws Exception
     */
    public function run(): void
    {

        Category::factory(10)->create()->each(function (Category $category) {
            $counts = [0, random_int(3, 7)];
            $category->children()->saveMany(Category::factory($counts[array_rand($counts)])->create()
                ->each(function (Category $category) {
                    $counts = [0, random_int(3, 7)];
                    $category->children()->saveMany(Category::factory($counts[array_rand($counts)])->create());
                }));
        });
    }
}
