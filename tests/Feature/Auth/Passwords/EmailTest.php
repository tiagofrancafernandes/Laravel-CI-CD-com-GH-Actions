<?php

namespace Tests\Feature\Auth\Passwords;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class EmailTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function canViewPasswordRequestPage()
    {
        $this->get(route('password.request'))
            ->assertSuccessful()
            ->assertSeeLivewire('auth.passwords.email');
    }

    /** @test */
    public function aUserMustEnterAnEmailAddress()
    {
        Livewire::test('auth.passwords.email')
            ->call('sendResetPasswordLink')
            ->assertHasErrors(['email' => 'required']);
    }

    /** @test */
    public function aUserMustEnterAValidEmailAddress()
    {
        Livewire::test('auth.passwords.email')
            ->set('email', 'email')
            ->call('sendResetPasswordLink')
            ->assertHasErrors(['email' => 'email']);
    }

    /** @test */
    public function aUserWhoEntersAValidEmailAddressWillGetSentAnEmail()
    {
        $user = User::factory()->create();

        Livewire::test('auth.passwords.email')
            ->set('email', $user->email)
            ->call('sendResetPasswordLink')
            ->assertNotSet('emailSentMessage', false);

        $this->assertDatabaseHas('password_reset_tokens', [
            'email' => $user->email,
        ]);
    }
}
