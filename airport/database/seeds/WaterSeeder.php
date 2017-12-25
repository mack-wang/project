<?php

use Illuminate\Database\Seeder;

class WaterSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(GrassesSeeder::class);
        $this->call(GrassAttrsSeeder::class);
    }
}
