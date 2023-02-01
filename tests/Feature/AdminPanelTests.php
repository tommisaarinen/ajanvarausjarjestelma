<?php

namespace Tests\Feature;

use App\Models\Admin;
use App\Models\Customer;
use App\Models\Location;
use App\Models\Service;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AdminPanelTests extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_AdminPanelReturns_302()
    {
        $response = $this->get('/admin/adminpanel');

        $response->assertStatus(302);
    }

    public function test_AdminPanelReturns_405_OnPost()
    {
        $response = $this->post('/admin/adminpanel');

        $response->assertStatus(405);
    }

    public function test_LocationEditorReturns_200()
    {
        $admin = Admin::factory()->create();
        $service = Service::factory()->create();
        $location = Location::factory()->create();
        $response = $this->actingAs($admin, 'admin')
        ->get('/admin/editlocation?lct_id=1');
        $response->assertStatus(200);
    }

    public function test_LocationEditorReturns_302_WhenLoggedInAsCustomer()
    {
        $user = Customer::factory()->create();
        $service = Service::factory()->create();
        $location = Location::factory()->create();
        $response = $this->actingAs($user)->get('/admin/editlocation?lct_id=1');
        $response->assertStatus(302);
    }

    public function test_LocationCreatorReturns_302_WhenLoggedInAsCustomer()
    {
        $user = Customer::factory()->create();
        $response = $this->actingAs($user)->get('/admin/createlocation');
        $response->assertStatus(302);
    }

    public function test_RemoveLocationReturns_200()
    {
        $admin = Admin::factory()->create();
        $location = Location::factory()->create();
        $response = $this->actingAs($admin, 'admin')
        ->post('/admin/rmlocation', ['location_id' => $location->id]);
        $response->assertStatus(200);
    }
}
