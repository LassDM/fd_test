<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Driver>
 */
class DriverFactory extends Factory
{
    protected $model = \App\Models\Driver::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $sex = [
            0 => 'male',
            1 => 'female'
        ];
        $currentSex = $sex[mt_rand(0,1)];
        return [
            'name' => $this->faker->firstName($currentSex) . " " .$this->faker->unique()->lastName($currentSex)
        ];
    }
}
