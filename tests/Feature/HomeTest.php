<?php

namespace Tests\Feature;

use App\Models\Click;
use App\Models\Link;
use App\Models\User;
use Inertia\Testing\AssertableInertia;
use Tests\TestCase;

class HomeTest extends TestCase
{
    public function testHomeUnreachableForGuests(): void
    {
        $this->get(route('home'))->assertRedirectToRoute('login');
    }

    public function testHomeRenders(): void
    {
        $user = User::factory()->create();
        $links = Link::factory(10)->create(['user_id' => $user->id]);
        Click::factory(20)->create(['model_type' => Link::class, 'model_id' => $links->first()->id]);

        $this->actingAs($user);
        $this->get(route('home'))
            ->assertOk()
            ->assertInertia(fn (AssertableInertia $page) => $page
                ->component('Home/Index')
                ->where('totalLinks', 10)
                ->where('totalClicks', 20));
    }
}
