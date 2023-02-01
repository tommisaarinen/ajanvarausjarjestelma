<?php

namespace Tests\Feature;

use App\Models\Location;
use App\Models\Service;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ModelTests extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_createsService()
    {
        $response = $this->post('/admin/srvchandle', [
            'action' => "create",
            'srvcname' => "TestService",
            't_est' => 1,
            'available' => 1
        ]);
        $response->assertStatus(302);
    }

    public function test_createsLocation() 
    {
        $response = $this->post('/admin/lcthandle', [
            'action' => "create",
            'lctname' => "TestLocation",
            'address' => "Test Street 1",
            'zip' => "69420",
            'city' => "Test City",

            'ma-open' => "08:00",
            'ma-close' => "16:00",
            'ti-open' => "08:00",
            'ti-close' => "16:00",
            'ke-open' => "08:00",
            'ke-close' => "16:00",
            'to-open' => "08:00",
            'to-close' => "16:00",
            'pe-open' => "08:00",
            'pe-close' => "16:00",
            'la-open' => "08:00",
            'la-close' => "16:00",

            'available-ma' => [1],
            'available-ti' => [1],
            'available-ke' => [1],
            'available-to' => [1],
            'available-pe' => [1],
            'available-la' => [1],
        ]);
        $response->assertStatus(302);
    }

    public function test_createsCustomerAndReservation()
    {
        $day = "+7 days";
        $startString = $day . " 09:00";
        $endString = $day . " 10:00";

        $service = Service::create([
            'name' => "TestService",
            'available' => 1,
            't_est' => 1
        ]);

        $open = (object)[
            "ma"=>["08:00", "16:00"],
            "ti"=>["08:00", "16:00"],
            "ke"=>["08:00", "16:00"],
            "to"=>["08:00", "16:00"],
            "pe"=>["08:00", "16:00"],
            "la"=>["08:00", "16:00"],
            "su"=>["08:00", "16:00"]
        ];
        
        $available = (object)[
            "ma"=>[$service->id],
            "ti"=>[$service->id],
            "ke"=>[$service->id],
            "to"=>[$service->id],
            "pe"=>[$service->id],
            "la"=>[$service->id],
            "su"=>[$service->id]
        ];

        $location = Location::create([
            'city' => "Test City",
            'address' => "Test Street 1",
            'zip' => "69420",
            'name' => "TestLocation",
            'open' => $open,
            'available_services' => $available
        ]);

        $response = $this->post('/makereservation', [
            'fname' => fake()->firstName(),
            'lname' => fake()->lastName(),
            'phone' => fake()->e164PhoneNumber(),
            'email' => fake()->email(),
            'ts_start' => strtotime($startString),
            'ts_end' => strtotime($endString),
            'service' => $service->id,
            'location' => $location->id
        ]);
        
        $response->assertStatus(200);
    }
}
