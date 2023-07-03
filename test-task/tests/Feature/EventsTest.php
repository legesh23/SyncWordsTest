<?php

namespace Tests\Feature;

use App\Models\Event;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class EventsTest extends TestCase
{
    use DatabaseTransactions;

    public function test_get_list_for_user(): void
    {
        $user = User::factory()->create();
        $events = Event::factory(2)->create([
            'organization_id' => $user->id
        ]);
        Sanctum::actingAs($user);

        $this->json('GET', "/api/list")
            ->assertStatus(200)
            ->assertJsonFragment(['id' => $events[0]['id']])
            ->assertJsonFragment(['id' => $events[1]['id']]);
    }

    public function test_get_event_by_id(): void
    {
        $user = User::factory()->create();
        $event = Event::factory()->create([
            'organization_id' => $user->id
        ]);
        Sanctum::actingAs($user);

        $this->json('GET', "/api/{$event->id}")
            ->assertStatus(200)
            ->assertJsonFragment(['event_title' => $event['event_title']]);
    }

    public function test_update_event_row_by_id(): void
    {
        $user = User::factory()->create();
        $event = Event::factory()->create([
            'event_title' => 'original_title',
            'organization_id' => $user->id
        ]);
        Sanctum::actingAs($user);

        $this->json('PATCH', "/api/{$event->id}", [
            'event_title' => 'new title'
        ])->assertStatus(200);

        $event->refresh();
        $this->assertEquals('new title', trim($event->event_title));
    }

    public function test_update_event_by_id(): void
    {
        $user = User::factory()->create();
        $event = Event::factory()->create([
            'event_title' => 'original_title',
            'organization_id' => $user->id
        ]);
        Sanctum::actingAs($user);

        $this->json('PUT', "/api/{$event->id}", [
            'event_title' => 'new title'
        ])->assertStatus(422)
            ->assertJsonFragment(['event_start_date' => ["The event start date field is required."]]);

        $this->json('PUT', "/api/{$event->id}", [
            'event_title' => 'new title',
            'event_start_date' => Carbon::now()->subDays(2),
            'event_end_date' => Carbon::now()->addDays(2),
        ])->assertStatus(200);

        $event->refresh();
        $this->assertEquals('new title', trim($event->event_title));
    }

    public function test_delete_event_by_id(): void
    {
        $user = User::factory()->create();
        $event = Event::factory()->create([
            'organization_id' => $user->id
        ]);
        Sanctum::actingAs($user);

        $this->json('DELETE', "/api/{$event->id}")
            ->assertStatus(200);
        $this->assertDatabaseMissing('events', [
            'id' => $event->id
        ]);
    }
}
