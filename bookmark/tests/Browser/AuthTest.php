<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class AuthTest extends DuskTestCase
{
    use DatabaseMigrations;

    /**
     * A Dusk test example.
     *
     * @return void
     */
    public function testRegistration()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/')
                    ->click('@register-link')
                    ->assertVisible('@register-heading')
                    ->type('@name-input', 'Joe Smith')
                    ->type('@email-input', 'joe@gmail.com')
                    ->type('@password-input', 'asdfasdf')
                    ->type('@password-confirm-input', 'asdfasdf')
                    ->click('@register-button')
                    ->assertVisible('@welcome-heading')
                    ->assertSee('Joe');
        });
    }

    public function testFailedRegistration()
    {
        $this->browse(function (Browser $browser) {
            $browser->logout()
                    ->visit('/register')
                    ->click('@register-button')
                    ->assertVisible('@error-field-name')
                    ->assertVisible('@error-field-email')
                    ->assertVisible('@error-field-password');
        });
    }

    public function testLogin()
    {
        $this->seed();

        $this->browse(function (Browser $browser) {
            $browser->logout()
                    ->visit('/login')
                    ->type('@email-input', 'jill@harvard.edu')
                    ->type('@password-input', 'asdfasdf')
                    ->click('@login-button')
                    ->assertVisible('@welcome-heading')
                    ->assertSee('Jill');
        });
    }

    public function testFailedLogin()
    {
        $this->browse(function (Browser $browser) {
            $browser->logout()
                    ->visit('/login')
                    ->type('@email-input', 'fail@gmail.com')
                    ->type('@password-input', 'fail')
                    ->click('@login-button')
                    ->assertVisible('@error-field-email')
                    ->assertSee('These credentials do not match our records.');
        });
    }
}