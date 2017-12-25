<?php

namespace Tests\Browser;

use Laravel\Dusk\Browser;
use Tests\DuskTestCase;


class FetchTest extends DuskTestCase
{
    /**
     * A Dusk test example.
     *
     * @return void
     */
    public function testExample()
    {
        for ($i = 1; $i < 301; $i++) {
            $this->browse(function (Browser $browser) use ($i) {
                $browser->visit('/spider/' . $i);
            });
        }
    }
}
