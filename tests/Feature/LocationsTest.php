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
        
        $response = $this->post(route('locations.store'), $request);
        
        $this->assertDatabaseHas('locations', $request);
        self::assertCount(1, $user->locations);
        $response->assertStatus(302);
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

    public function test_delete_unauthorized_location()
    {
        /** @var User $user */
        $user = User::factory()->create();
        $this->actingAs($user);

        $locations = Location::factory(5)->create();

        $response = $this->delete(route('locations.destroy', $locations->first()->id));

        $response->assertStatus(403);
    }

    public function test_delete_location()
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
        $this->post(route('locations.store'), $request);

        $response = $this->delete(route('locations.destroy', $user->locations->first()));
        
        self::assertCount(1, $user->locations->fresh()->all());
        $response->assertStatus(302);
        $response->assertRedirect(route('locations.index'));
    }

    public function test_update_location_title_description()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $location = Location::factory()->create(['user_id' => $user->id]);
        
        $response = $this->put(route('locations.update', $location), [
            'title' => 'updated title',
            'description' => 'updated description',
            'longitude' => $location->longitude,
            'latitude' => $location->latitude
        ]);

        $response->assertStatus(302);
        $this->assertEquals($location->fresh()->title, 'updated title');
        $this->assertEquals($location->fresh()->description, 'updated description');
    }
}
