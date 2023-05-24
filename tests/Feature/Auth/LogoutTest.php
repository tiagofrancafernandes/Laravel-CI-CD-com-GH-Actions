<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;

class LogoutTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function anAuthenticatedUserCanLogOut()
    {
        $user = User::factory()->create();
        $this->be($user);

        $this->assertTrue(Auth::check());

        $this->post(route('logout'))
            ->assertStatus(302)
            ->assertRedirect(route('home'));

        $this->assertFalse(Auth::check());
    }

    /** @test */
    public function anUnauthenticatedUserCanNotLogOut()
    {
        $this->post(route('logout'))
            ->assertRedirect(route('login'));

        $this->assertFalse(Auth::check());
    }
}
