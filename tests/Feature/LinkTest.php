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

    public function testLinksPagerenders(): void
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
}
