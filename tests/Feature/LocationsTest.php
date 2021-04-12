<?php

namespace Tests\Feature;

use App\Models\Location;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * @group Locations
 */
class LocationsTest extends TestCase
{
    use RefreshDatabase;

    public function test_create_valid_location()
    {
        /** @var User $user */
        $user = User::factory()->create();
        $this->actingAs($user);

        $request = [
            'title' => 'test',
            'description' => 'test description',
            'longitude' => 10.22,
            'latitude' => 10.22,
        ];

        $this->post(route('locations.store'), $request);

        $this->assertDatabaseHas('locations', $request);
        self::assertCount(1, $user->locations);
    }

    public function test_create_invalid_location()
    {
        $this->actingAs(User::factory()->create());

        $response = $this->post(route('locations.store'), [
            'title' => 'test',
            'description' => 'test description',
            'longitude' => 10.22,
            'latitude' => 'djksajddashiu'
        ]);


        $response->assertSessionHasErrors('latitude');
        $response->assertRedirect();
    }

    public function test_delete_location()
    {
        /** @var User $user */
        $user = User::factory()->create();
        $this->actingAs($user);

        $locations = Location::factory(5)->create();

        $response = $this->delete(route('locations.destroy', $locations->first()->id));

        $response->assertStatus(403);
    }
}
