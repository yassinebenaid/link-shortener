<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Inertia\Testing\AssertableInertia;
use Tests\TestCase;

class LoginTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function testLoginPageIsUnreachableForAuthenticatedUsers(): void
    {
        $this->actingAs(User::factory()->create())
            ->get(route('login'))
            ->assertRedirectToRoute('home');
    }

    public function testLoginPageRenders(): void
    {
        $this->get(route('login'))
            ->assertOk()
            ->assertInertia(fn (AssertableInertia $page) => $page
                ->component('Auth/Login'));
    }

    public function testCannotLoginWithInvalidCredentials(): void
    {
        $this->post(route('login'), [
            'email' => null,
            'password' => null,
        ])
            ->assertRedirect()
            ->assertSessionHasErrors(['email', 'password']);

        $this->post(route('login'), [
            'email' => 'invalid-email',
            'password' => 'somepassword',
        ])
            ->assertRedirect()
            ->assertSessionDoesnthaveErrors('password')
            ->assertSessionHasErrors(['email']);

        User::factory()->create(['email' => 'ysbenaid@gmail.com']);

        $this->post(route('login'), [
            'email' => 'ysbenaid@gmail.com',
            'password' => 'invalid-password',
        ])
            ->assertRedirect()
            ->assertSessionHasErrors('email');
    }

    public function testCanLogin(): void
    {
        $user = User::factory()->create(['email' => 'ysbenaid@gmail.com']);

        $this->post(route('login'), [
            'email' => 'ysbenaid@gmail.com',
            'password' => 'password',
        ])
            ->assertRedirect()
            ->assertSessionHasNoErrors();

        $this->assertAuthenticatedAs($user);
    }
}
