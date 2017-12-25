<?php

use Illuminate\Database\Seeder;

class CompanyInfoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //管理员表填充
        DB::table('company_infos')->delete();
        DB::table('company_infos')->insert([
            'id' => 1,
            'article_id' => 38,
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);
    }
}
