<?php

namespace Database\Factories;

use App\Models\SubCategory;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class SubCategoryFactory extends Factory
{
    protected $model = SubCategory::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->text(10),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ];
    }
}
