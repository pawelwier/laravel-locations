<?php

namespace Tests\Feature;

use App\Models\Location;
use App\Models\User;
use App\Models\Recommendation;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * @group Recommendations
 */
class RecommendationsTest extends TestCase
{
    use RefreshDatabase;

    public function test_create_valid_recommendation()
    {
        /** @var User $user */
        $user = User::factory()->create();
        $this->actingAs($user);

        $location = Location::factory()->create();

        $request = [
            'user_id' => $user->id,
            'location_id' => $location->id,
            'message' => 'Test'
        ];

        $response = $this->post(route('recommendations.store'), $request);
        $this->assertDatabaseHas('recommendations', $request);
        self::assertCount(1, $user->recommendations);
        $response->assertStatus(302);
    }
}
