<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Tests\TestCase;
use Livewire\Livewire;
use Illuminate\Auth\Events\Registered;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Event;

class RegisterTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function registrationPageContainsLivewireComponent()
    {
        $this->get(route('register'))
            ->assertSuccessful()
            ->assertSeeLivewire('auth.register');
    }

    /** @test */
    public function isRedirectedIfAlreadyLoggedIn()
    {
        $user = User::factory()->create();

        $this->be($user);

        $this->get(route('register'))
            ->assertRedirect(route('home'));
    }

    /** @test */
    public function aUserCanRegister()
    {
        Event::fake();

        Livewire::test('auth.register')
            ->set('name', 'Tall Stack')
            ->set('email', 'tallstack@example.com')
            ->set('password', 'password')
            ->set('passwordConfirmation', 'password')
            ->call('register')
            ->assertRedirect(route('home'));

        $this->assertTrue(User::whereEmail('tallstack@example.com')->exists());
        $this->assertEquals('tallstack@example.com', Auth::user()->email);

        Event::assertDispatched(Registered::class);
    }

    /** @test */
    public function nameIsRequired()
    {
        Livewire::test('auth.register')
            ->set('name', '')
            ->call('register')
            ->assertHasErrors(['name' => 'required']);
    }

    /** @test */
    public function emailIsRequired()
    {
        Livewire::test('auth.register')
            ->set('email', '')
            ->call('register')
            ->assertHasErrors(['email' => 'required']);
    }

    /** @test */
    public function emailIsValidEmail()
    {
        Livewire::test('auth.register')
            ->set('email', 'tallstack')
            ->call('register')
            ->assertHasErrors(['email' => 'email']);
    }

    /** @test */
    public function emailHasntBeenTakenAlready()
    {
        User::factory()->create(['email' => 'tallstack@example.com']);

        Livewire::test('auth.register')
            ->set('email', 'tallstack@example.com')
            ->call('register')
            ->assertHasErrors(['email' => 'unique']);
    }

    /** @test */
    public function seeEmailHasntAlreadyBeenTakenValidationMessageAsUserTypes()
    {
        User::factory()->create(['email' => 'tallstack@example.com']);

        Livewire::test('auth.register')
            ->set('email', 'smallstack@gmail.com')
            ->assertHasNoErrors()
            ->set('email', 'tallstack@example.com')
            ->call('register')
            ->assertHasErrors(['email' => 'unique']);
    }

    /** @test */
    public function passwordIsRequired()
    {
        Livewire::test('auth.register')
            ->set('password', '')
            ->set('passwordConfirmation', 'password')
            ->call('register')
            ->assertHasErrors(['password' => 'required']);
    }

    /** @test */
    public function passwordIsMinimumOfEightCharacters()
    {
        Livewire::test('auth.register')
            ->set('password', 'secret')
            ->set('passwordConfirmation', 'secret')
            ->call('register')
            ->assertHasErrors(['password' => 'min']);
    }

    /** @test */
    public function passwordMatchesPasswordConfirmation()
    {
        Livewire::test('auth.register')
            ->set('email', 'tallstack@example.com')
            ->set('password', 'password')
            ->set('passwordConfirmation', 'not-password')
            ->call('register')
            ->assertHasErrors(['password' => 'same']);
    }
}
