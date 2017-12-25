<?php

use Illuminate\Database\Seeder;

class ActivityRequiresSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('activity_requires')->delete();
        DB::table('activity_requires')->insert([
            'activity_id' => 1,
            'exp' => 100,
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);
        DB::table('activity_requires')->insert([
            'activity_id' => 2,
            'level' => 3,
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);
        DB::table('activity_requires')->insert([
            'activity_id' => 3,
            'level' => 5,
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);
        DB::table('activity_requires')->insert([
            'activity_id' => 4,
            'exp' => 100,
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);
        DB::table('activity_requires')->insert([
            'activity_id' => 5,
            'level' => 3,
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);
        DB::table('activity_requires')->insert([
            'activity_id' => 6,
            'exp' => 100,
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);
        DB::table('activity_requires')->insert([
            'activity_id' => 7,
            'level' => 2,
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);
        DB::table('activity_requires')->insert([
            'activity_id' => 8,
            'exp' => 300,
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);
        DB::table('activity_requires')->insert([
            'activity_id' => 9,
            'exp' => 200,
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);
        DB::table('activity_requires')->insert([
            'activity_id' => 10,
            'level' => 1,
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);
        DB::table('activity_requires')->insert([
            'activity_id' => 11,
            'level' => 1,
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);
        DB::table('activity_requires')->insert([
            'activity_id' => 12,
            'level' => 2,
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);
        DB::table('activity_requires')->insert([
            'activity_id' => 13,
            'level' => 1,
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);
        DB::table('activity_requires')->insert([
            'activity_id' => 14,
            'level' => 1,
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);
        DB::table('activity_requires')->insert([
            'activity_id' => 15,
            'level' => 1,
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);
    }
}
