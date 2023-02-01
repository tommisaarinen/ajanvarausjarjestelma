<?php

namespace Database\Factories;

use App\Models\Location;
use App\Models\Service;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Location>
 */
class LocationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */

    protected $model = Location::class;

    public function definition()
    {
        $services = Service::all();
        $serviceIDs = array();

        foreach($services as $el){
            array_push($serviceIDs, $el->id);
        }

        $serviceObject = (object)["ma" => $serviceIDs, "ti" => $serviceIDs, "ke" => $serviceIDs, "to" => $serviceIDs, "pe" => $serviceIDs, "la" => $serviceIDs, "su" => $serviceIDs];
        $open = (object)["ma" => ["08:00", "16:00"], "ti" => ["08:00", "16:00"], "ke" => ["08:00", "16:00"], "to" => ["08:00", "16:00"], "pe" => ["08:00", "16:00"], "la" => ["09:00", "16:00"], "su" => null];
        $address = fake()->streetName() . " " . rand(1, 80);
        
        return [
            'city' => fake()->city(),
            'address' => $address,
            'zip' => rand(0, 9) . rand(0, 9) . rand(0,9) . rand(0,9) . rand(0,9),
            'name' => fake()->company(),
            'open' => $open,
            'available_services' => $serviceObject
        ];
    }
}
