<?php

namespace Tests\Feature\Auth\Passwords;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;
use Livewire\Livewire;
use Tests\TestCase;

class ConfirmTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        Route::get('/must-be-confirmed', fn () => 'You must be confirmed to see this page.')->middleware(['web', 'password.confirm']);
    }

    /** @test */
    public function aUserMustConfirmTheirPasswordBeforeVisitingAProtectedPage()
    {
        $user = User::factory()->create();
        $this->be($user);

        $this->get('/must-be-confirmed')
            ->assertRedirect(route('password.confirm'));

        $this->followingRedirects()
            ->get('/must-be-confirmed')
            ->assertSeeLivewire('auth.passwords.confirm');
    }

    /** @test */
    public function aUserMustEnterAPasswordToConfirmIt()
    {
        Livewire::test('auth.passwords.confirm')
            ->call('confirm')
            ->assertHasErrors(['password' => 'required']);
    }

    /** @test */
    public function aUserMustEnterTheirOwnPasswordToConfirmIt()
    {
        $user = User::factory()->create([
            'password' => Hash::make('password'),
        ]);

        Livewire::test('auth.passwords.confirm')
            ->set('password', 'not-password')
            ->call('confirm')
            ->assertHasErrors(['password' => 'current_password']);
    }

    /** @test */
    public function aUserWhoConfirmsTheirPasswordWillGetRedirected()
    {
        $user = User::factory()->create([
            'password' => Hash::make('password'),
        ]);

        $this->be($user);

        $this->withSession(['url.intended' => '/must-be-confirmed']);

        Livewire::test('auth.passwords.confirm')
            ->set('password', 'password')
            ->call('confirm')
            ->assertRedirect('/must-be-confirmed');
    }
}
