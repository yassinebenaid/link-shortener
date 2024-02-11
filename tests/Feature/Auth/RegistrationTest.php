<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Inertia\Testing\AssertableInertia;
use Tests\TestCase;

class RegistrationTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function testRegistrationPageUnreachableByAuthenticatedUsers(): void
    {
        $this->actingAs(User::factory()->create())
            ->get(route('register'))
            ->assertRedirectToRoute('home');
    }

    public function testRegistrationPageRenders(): void
    {
        $this->get(route('register'))
            ->assertOk()
            ->assertInertia(fn (AssertableInertia $page) => $page
                ->component('Auth/Register'));
    }

    public function testCnannotRegisterWithInvalidInfo(): void
    {
        $this->assertGuest();

        $this->post(route('register'), [
            'name' => null,
            'email' => null,
            'password' => null,
            'password_confirmation' => null,
        ])
            ->assertRedirect()
            ->assertSessionHasErrors([
                'email', 'name', 'password',
            ]);

        $this->assertGuest();

        $this->post(route('register'), [
            'name' => 'yassinebenaid',
            'email' => 'invalid-email',
            'password' => 'password',
            'password_confirmation' => null,
        ])
            ->assertRedirect()
            ->assertSessionHasErrors([
                'email', 'password',
            ]);

        $this->assertGuest();

        $this->post(route('register'), [
            'name' => 'yassinebenaid',
            'email' => 'ysbenaid@gmail.com',
            'password' => 'password',
            'password_confirmation' => null,
        ])
            ->assertRedirect()
            ->assertSessionHasErrors([
                'password',
            ]);

        $this->assertGuest();
    }

    public function testCanRegister(): void
    {
        $this->assertDatabaseMissing('users', [
            'name' => 'yassinebenaid',
            'email' => 'ysbenaid@gmail.com',
        ]);

        $this->post(route('register'), [
            'name' => 'yassinebenaid',
            'email' => 'ysbenaid@gmail.com',
            'password' => 'password',
            'password_confirmation' => 'password',
        ])
            ->assertRedirectToRoute('home')
            ->assertSessionHasNoErrors();

        $this->assertDatabaseHas('users', [
            'name' => 'yassinebenaid',
            'email' => 'ysbenaid@gmail.com',
        ]);
    }
}
