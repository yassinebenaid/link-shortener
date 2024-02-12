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
        Click::factory(20)->create(['model_type' => Link::class, 'model_id' => $links->first()->id, 'created_at' => now()]);

        $this->actingAs($user);
        $this->get(route('home'))
            ->assertOk()
            ->assertInertia(fn (AssertableInertia $page) => $page
                ->component('Home/Index')
                ->where('totalLinks', 10)
                ->where('totalClicks', 20)
                ->count('clicksHistory', 30)
                ->where('clicksHistory.29.count', 20)
                ->where('clicksHistory.28.count', 0)); // make sure dates are correct
    }
}
