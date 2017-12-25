<?php

use Illuminate\Database\Seeder;

class GrassesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('grasses')->delete();
        DB::table('grasses')->insert([
            'id' => 2,
            'user_id' => 2,
            'water' => 300,
            'total' => 1000,
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s", strtotime("-1 week")),
        ]);
        DB::table('grasses')->insert([
            'id' => 3,
            'user_id' => 3,
            'water' => 300,
            'total' => 1000,
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s", strtotime("-1 week")),
        ]);
        DB::table('grasses')->insert([
            'id' => 4,
            'user_id' => 4,
            'water' => 300,
            'total' => 1000,
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s", strtotime("-1 week")),
        ]);
        DB::table('grasses')->insert([
            'id' => 5,
            'user_id' => 5,
            'water' => 300,
            'total' => 1000,
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s", strtotime("-1 week")),
        ]);
        DB::table('grasses')->insert([
            'id' => 6,
            'user_id' => 6,
            'water' => 300,
            'total' => 1000,
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s", strtotime("-1 week")),
        ]);
    }
}
