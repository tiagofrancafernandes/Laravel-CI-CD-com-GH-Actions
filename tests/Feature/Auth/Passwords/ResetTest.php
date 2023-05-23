<?php

namespace Tests\Feature\Auth\Passwords;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Livewire\Livewire;
use Tests\TestCase;

class ResetTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function canViewPasswordResetPage()
    {
        $user = User::factory()->create();

        $token = Str::random(16);

        DB::table('password_reset_tokens')->insert([
            'email' => $user->email,
            'token' => Hash::make($token),
            'created_at' => Carbon::now(),
        ]);

        $this->get(route('password.reset', [
            'email' => $user->email,
            'token' => $token,
        ]))
            ->assertSuccessful()
            ->assertSee($user->email)
            ->assertSeeLivewire('auth.passwords.reset');
    }

    /** @test */
    public function canResetPassword()
    {
        $user = User::factory()->create();

        $token = Str::random(16);

        DB::table('password_reset_tokens')->insert([
            'email' => $user->email,
            'token' => Hash::make($token),
            'created_at' => Carbon::now(),
        ]);

        Livewire::test('auth.passwords.reset', [
            'token' => $token,
        ])
            ->set('email', $user->email)
            ->set('password', 'new-password')
            ->set('passwordConfirmation', 'new-password')
            ->call('resetPassword');

        $this->assertTrue(Auth::attempt([
            'email' => $user->email,
            'password' => 'new-password',
        ]));
    }

    /** @test */
    public function tokenIsRequired()
    {
        Livewire::test('auth.passwords.reset', [
            'token' => null,
        ])
            ->call('resetPassword')
            ->assertHasErrors(['token' => 'required']);
    }

    /** @test */
    public function emailIsRequired()
    {
        Livewire::test('auth.passwords.reset', [
            'token' => Str::random(16),
        ])
            ->set('email', null)
            ->call('resetPassword')
            ->assertHasErrors(['email' => 'required']);
    }

    /** @test */
    public function emailIsValidEmail()
    {
        Livewire::test('auth.passwords.reset', [
            'token' => Str::random(16),
        ])
            ->set('email', 'email')
            ->call('resetPassword')
            ->assertHasErrors(['email' => 'email']);
    }

    /** @test */
    public function passwordIsRequired()
    {
        Livewire::test('auth.passwords.reset', [
            'token' => Str::random(16),
        ])
            ->set('password', '')
            ->call('resetPassword')
            ->assertHasErrors(['password' => 'required']);
    }

    /** @test */
    public function passwordIsMinimumOfEightCharacters()
    {
        Livewire::test('auth.passwords.reset', [
            'token' => Str::random(16),
        ])
            ->set('password', 'secret')
            ->call('resetPassword')
            ->assertHasErrors(['password' => 'min']);
    }

    /** @test */
    public function passwordMatchesPasswordConfirmation()
    {
        Livewire::test('auth.passwords.reset', [
            'token' => Str::random(16),
        ])
            ->set('password', 'new-password')
            ->set('passwordConfirmation', 'not-new-password')
            ->call('resetPassword')
            ->assertHasErrors(['password' => 'same']);
    }
}
