<?php

use Illuminate\Database\Seeder;

class CatalogSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //管理员表填充
        DB::table('catalogs')->delete();
        DB::table('catalogs')->insert([
            'id' => 1,
            'catalog' => '油',
            'auth' => 1,
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);
        DB::table('catalogs')->insert([
            'id' => 2,
            'catalog' => '米',
            'auth' => 1,
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);
        DB::table('catalogs')->insert([
            'id' => 3,
            'catalog' => '面粉',
            'auth' => 1,
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);
        DB::table('catalogs')->insert([
            'id' => 4,
            'catalog' => '挂面',
            'auth' => 1,
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);
        DB::table('catalogs')->insert([
            'id' => 5,
            'catalog' => '调味品',
            'auth' => 1,
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);
        DB::table('catalogs')->insert([
            'id' => 6,
            'catalog' => '食品饮品',
            'auth' => 1,
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);
        DB::table('catalogs')->insert([
            'id' => 7,
            'catalog' => '全球优品',
            'auth' => 1,
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);
        DB::table('catalogs')->insert([
            'id' => 8,
            'catalog' => '休闲食品',
            'auth' => 1,
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);
        DB::table('catalogs')->insert([
            'id' => 9,
            'catalog' => '日化',
            'auth' => 1,
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);
        DB::table('catalogs')->insert([
            'id' => 10,
            'catalog' => '钜合头条',
            'auth' => 1,
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);
        DB::table('catalogs')->insert([
            'id' => 11,
            'catalog' => '为您推荐',
            'recommend' => 1,
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);
        DB::table('catalogs')->insert([
            'id' => 12,
            'catalog' => '特色专区',
            'recommend' => 1,
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);
        DB::table('catalogs')->insert([
            'id' => 13,
            'catalog' => '企业介绍',
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);
    }
}
