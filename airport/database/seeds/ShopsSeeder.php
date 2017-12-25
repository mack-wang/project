<?php

use Illuminate\Database\Seeder;

class ShopsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //店铺填充
        DB::table('shops')->delete();
        DB::table('shops')->insert([
            'id' => 1,
            'name' => '杭州烟草店',
            'phone' => '15757130092',
            'cigarette_id' => '12345678' . rand(1000, 9999),
            'area_id' => 1,
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);
        DB::table('shops')->insert([
            'id' => 2,
            'name' => '嘉兴烟草店',
            'phone' => '15757130093',
            'cigarette_id' => '12345678' . rand(1000, 9999),
            'area_id' => 2,
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);
        DB::table('shops')->insert([
            'id' => 3,
            'name' => '湖州烟草店',
            'phone' => '15757130014',
            'cigarette_id' => '12345678' . rand(1000, 9999),
            'area_id' => 3,
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);
        DB::table('shops')->insert([
            'id' => 4,
            'name' => '萧山机场吸烟室B1',
            'phone' => '15757130095',
            'cigarette_id' => '12345678' . rand(1000, 9999),
            'area_id' => 4,
            'type' => 'airport',
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);
        DB::table('shops')->insert([
            'id' => 5,
            'name' => '萧山机场吸烟室B2',
            'phone' => '15757130096',
            'cigarette_id' => '12345678' . rand(1000, 9999),
            'area_id' => 5,
            'type' => 'airport',
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);
        DB::table('shops')->insert([
            'id' => 6,
            'name' => '金华烟草店',
            'phone' => '15757130013',
            'cigarette_id' => '12345678' . rand(1000, 9999),
            'area_id' => 6,
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);
        DB::table('shops')->insert([
            'id' => 7,
            'name' => '丽水烟草店',
            'phone' => '15757130099',
            'cigarette_id' => '12345678' . rand(1000, 9999),
            'area_id' => 7,
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);
    }
}
