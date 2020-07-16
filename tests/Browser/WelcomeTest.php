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
     * test
     * @return void
     */
    public function welcomeTitle()
    {
        $this->markTestIncomplete();

        $this->browse(function (Browser $browser) {
            echo $browser->text();
            $browser->visit('/')
                    ->assertSee('EHR EPIC');
        });
    }
}
