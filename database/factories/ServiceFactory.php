<?php

namespace Database\Factories;

use App\Models\Service;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Service>
 */
class ServiceFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */

    protected $model = Service::class;

    public function definition()
    {
        $t_estArr = array(0.5, 1.0, 1.5, 2.0, 2.5, 3.0);
        return [
            'name' => fake()->bs(),
            'available' => 1,
            't_est' => $t_estArr[array_rand($t_estArr, 1)]
        ];
    }
}
