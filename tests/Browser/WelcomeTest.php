<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class WelcomeTest extends DuskTestCase
{
    /**
     * A Dusk test example.
     *
     * @test
     * @return void
     */
    public function welcomeTitle()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/')
                    ->assertSee('EHR EPIC');
        });
    }
}
