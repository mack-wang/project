<?php

use Illuminate\Database\Seeder;

class GrassAttrsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('grass_attrs')->delete();
        DB::table('grass_attrs')->insert([
            'user_id' => 1,
            'water' => 2000,
            'seed' => 12,
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);
        DB::table('grass_attrs')->insert([
            'user_id' => 2,
            'water' => 2000,
            'seed' => 1,
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);
        DB::table('grass_attrs')->insert([
            'user_id' => 3,
            'water' => 2000,
            'seed' => 12,
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);
        DB::table('grass_attrs')->insert([
            'user_id' => 4,
            'water' => 2000,
            'seed' => 12,
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);
        DB::table('grass_attrs')->insert([
            'user_id' => 5,
            'water' => 2000,
            'seed' => 12,
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);
        DB::table('grass_attrs')->insert([
            'user_id' => 6,
            'water' => 2000,
            'seed' => 12,
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);
    }
}
