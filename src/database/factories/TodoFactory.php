<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Todo;
use App\Models\Category;

class TodoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    protected $model = Todo::class;
    public function definition(): array
    {
        return [
            'category_id' => Category::factory(),
            'content'     => $this->faker->sentence(3)
        ];
    }
}
