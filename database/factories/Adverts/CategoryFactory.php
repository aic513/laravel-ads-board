<?php

namespace Database\Factories\Adverts;

use App\Models\Adverts\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

class CategoryFactory extends Factory
{
    protected $model = Category::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->unique()->name,
            'slug' => $this->faker->unique()->slug(2),
            'parent_id' => null,
        ];
    }
}
