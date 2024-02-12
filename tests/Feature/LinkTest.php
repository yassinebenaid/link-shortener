<?php

namespace Tests\Feature;

use App\Models\Link;
use App\Models\User;
use Inertia\Testing\AssertableInertia;
use Tests\TestCase;

class LinkTest extends TestCase
{
    public function testLinksPageUnreachableByGuests(): void
    {
        $this->get(route('links.index'))->assertRedirectToRoute('login');
    }

    public function testLinksPageRenders(): void
    {
        $user = User::factory()->create();
        Link::factory(10)->create(['user_id' => $user->id]);

        $this->actingAs($user)
            ->get(route('links.index'))
            ->assertOk()
            ->assertInertia(fn (AssertableInertia $page) => $page
                ->component('Link/Index')
                ->count('links.data', 10));
    }

    public function testCanSortLinks(): void
    {
        $user = User::factory()->create();
        $links = Link::factory(10)->create(['user_id' => $user->id]);

        $this->actingAs($user)
            ->get(route('links.index', ['sort' => 'id.desc']))
            ->assertOk()
            ->assertInertia(fn (AssertableInertia $page) => $page
                ->component('Link/Index')
                ->count('links.data', 10)
                ->where('links.data.0.id', $links->last()->id)
                ->etc());
    }

    public function testGuestsCannotCreateLinks(): void
    {
        $this->postJson(route('links.store'))->assertStatus(401);
    }

    public function testCannotCreateLinksWithInvalidInfo(): void
    {
        $user = User::factory()->create();

        $this->assertDatabaseMissing('links', ['user_id' => $user->id]);

        $this->actingAs($user)
            ->postJson(route('links.store'), [
                'original' => null,
            ])
            ->assertJsonMissingValidationErrors('slug')
            ->assertJsonValidationErrorFor('original');

        $this->actingAs($user)
            ->postJson(route('links.store'), [
                'original' => fake()->url(),
                'slug' => fake()->sentence(256), // exceeded 255
            ])
            ->assertJsonMissingValidationErrors('original')
            ->assertJsonValidationErrorFor('slug');

        $this->assertDatabaseMissing('links', ['user_id' => $user->id]);

        $this->actingAs($user)
            ->postJson(route('links.store'), [
                'original' => fake()->url(),
                'slug' => 'invalid because it contains spaces', // invalid format
            ])
            ->assertJsonMissingValidationErrors('original')
            ->assertJsonValidationErrorFor('slug');

        $this->actingAs($user)
            ->postJson(route('links.store'), [
                'original' => null,
                'slug' => 'valid-slug',
            ])
            ->assertJsonMissingValidationErrors('slug')
            ->assertJsonValidationErrorFor('original');

        $this->actingAs($user)
            ->postJson(route('links.store'), [
                'original' => null,
                'slug' => 'validslug',
            ])
            ->assertJsonMissingValidationErrors('slug')
            ->assertJsonValidationErrorFor('original');

        $this->assertDatabaseMissing('links', ['user_id' => $user->id]);
    }

    public function testCanCreateLinks(): void
    {
        $user = User::factory()->create();

        $this->assertDatabaseMissing('links', ['user_id' => $user->id]);

        $this->actingAs($user)
            ->postJson(route('links.store'), [
                'original' => fake()->url(),
            ])
            ->assertRedirect()
            ->assertSessionHasNoErrors();

        $this->assertDatabaseHas('links', ['user_id' => $user->id]);
    }

    public function testGuestsCannotDeleteLinks(): void
    {
        $user = User::factory()->create();
        $link = Link::factory()->create(['user_id' => $user->id]);

        $this->deleteJson(route('links.destroy', $link))->assertStatus(401);

        $this->assertNotNull($link->fresh());
    }

    public function testUsersCannotDeleteLinksTheyDontOwn(): void
    {
        $user = User::factory()->create();
        $owner = User::factory()->create();
        $link = Link::factory()->create(['user_id' => $owner->id]);

        $this->actingAs($user)
            ->deleteJson(route('links.destroy', $link))
            ->assertStatus(403);

        $this->assertNotNull($link->fresh());
    }

    public function testUsersCanDeleteLinks(): void
    {
        $user = User::factory()->create();
        $link = Link::factory()->create(['user_id' => $user->id]);

        $this->actingAs($user)
            ->deleteJson(route('links.destroy', $link))
            ->assertStatus(204);

        $this->assertNull($link->fresh());
    }

    public function testCannotUseInvalidLink(): void
    {
        $this->get(
            route('links.out', [
                'link' => 'invalid',
            ])
        )->assertInertia(fn (AssertableInertia $page) => $page
            ->component('Link/Invalid'));
    }

    public function testCanUseLink(): void
    {
        $user = User::factory()->create();
        $link = Link::factory()->create(['user_id' => $user->id]);

        $this->get(route('links.out', [
            'link' => $link->slug,
        ]))
            ->assertRedirect($link->original);
    }
}
