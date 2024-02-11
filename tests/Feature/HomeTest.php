<?php

namespace Tests\Feature;

// use Illuminate\Foundation\Testing\RefreshDatabase;

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

        $this->actingAs($user);
        $this->get(route('home'))
            ->assertOk()
            ->assertInertia(fn (AssertableInertia $page) => $page
                ->component('Home/Index'));
    }
}
