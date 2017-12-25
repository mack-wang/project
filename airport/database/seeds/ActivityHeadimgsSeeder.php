<?php

use Illuminate\Database\Seeder;

class ActivityHeadimgsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('activity_headimgs')->delete();
        DB::table('activity_headimgs')->insert([
            'activity_id' => 1,
            'image_path' => '/storage/headimage/frw1.png,/storage/headimage/frw2.png',
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);
        DB::table('activity_headimgs')->insert([
            'activity_id' => 2,
            'image_path' => '/storage/headimage/frw1.png,/storage/headimage/frw2.png',
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);
        DB::table('activity_headimgs')->insert([
            'activity_id' => 3,
            'image_path' => '/storage/headimage/htx1.jpg,/storage/headimage/htx2.jpg,/storage/headimage/htx3.jpg,/storage/headimage/htx4.jpg',
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);
    }
}
