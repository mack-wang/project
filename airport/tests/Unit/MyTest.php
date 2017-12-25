<?php

namespace Tests\Unit;

use App\Models\Shop;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class MyTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testBasicTest()
    {
        for($i=1;$i<301;$i++){
            $this->get('/spider/'.$i)
                 ->assertSee('成功');
        }
    }
}
